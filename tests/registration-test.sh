#!/bin/bash

################################################################################
# PEWACA REGISTRATION TESTING SCRIPT
# 
# Script ini digunakan untuk testing otomatis flow registrasi warga
# dari awal hingga akhir (end-to-end testing)
#
# Usage:
#   ./tests/registration-test.sh
#   ./tests/registration-test.sh --uuid YOUR-UUID
#   ./tests/registration-test.sh --help
#
# Author: Pewaca Development Team
# Version: 1.0
# Last Updated: 26 Oktober 2025
################################################################################

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# API Configuration
API_BASE_URL="https://admin.pewaca.id/api"
FRONTEND_URL="https://pewaca-frontend.repl.co"

# Default test data
DEFAULT_UUID="a1b2c3d4-e5f6-7890-abcd-ef1234567890"
TEST_EMAIL="test.warga.$(date +%s)@example.com"
TEST_PASSWORD="TestPassword123"
TEST_NIK="3174010112900$(date +%s | tail -c 4)"
TEST_FULL_NAME="Test Warga Auto"
TEST_PHONE="08123456$(date +%s | tail -c 5)"

# Test results
TOTAL_TESTS=0
PASSED_TESTS=0
FAILED_TESTS=0

################################################################################
# Helper Functions
################################################################################

print_header() {
    echo ""
    echo -e "${BLUE}========================================${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}========================================${NC}"
    echo ""
}

print_test() {
    echo -e "${YELLOW}[TEST]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[✓]${NC} $1"
    ((PASSED_TESTS++))
}

print_error() {
    echo -e "${RED}[✗]${NC} $1"
    ((FAILED_TESTS++))
}

print_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

increment_test() {
    ((TOTAL_TESTS++))
}

# HTTP Request Helper
make_request() {
    local method=$1
    local endpoint=$2
    local data=$3
    local content_type=${4:-"application/json"}
    
    if [ -z "$data" ]; then
        curl -s -X "$method" \
            -H "Accept: application/json" \
            -H "Content-Type: $content_type" \
            "${API_BASE_URL}${endpoint}"
    else
        curl -s -X "$method" \
            -H "Accept: application/json" \
            -H "Content-Type: $content_type" \
            -d "$data" \
            "${API_BASE_URL}${endpoint}"
    fi
}

# JSON Parser (requires jq)
check_jq() {
    if ! command -v jq &> /dev/null; then
        echo -e "${RED}Error: jq is not installed${NC}"
        echo "Please install jq: sudo apt-get install jq"
        exit 1
    fi
}

################################################################################
# Test Functions
################################################################################

test_get_residence_by_code() {
    print_test "Test 1: GET Residence by Code"
    increment_test
    
    local response=$(make_request "GET" "/residence-by-code/${REGISTRATION_UUID}/")
    local success=$(echo "$response" | jq -r '.data != null')
    
    if [ "$success" == "true" ]; then
        local residence_name=$(echo "$response" | jq -r '.data.residence_name')
        print_success "Residence ditemukan: $residence_name"
        echo "$response" > /tmp/residence_data.json
        return 0
    else
        print_error "Gagal mengambil data residence"
        echo "Response: $response"
        return 1
    fi
}

test_get_units_by_code() {
    print_test "Test 2: GET Units by Code"
    increment_test
    
    local response=$(make_request "GET" "/units/code/${REGISTRATION_UUID}/")
    local has_data=$(echo "$response" | jq -r '.data != null')
    
    if [ "$has_data" == "true" ]; then
        local unit_count=$(echo "$response" | jq -r '.data | length')
        print_success "Ditemukan $unit_count unit"
        
        # Save first unit_id for registration
        UNIT_ID=$(echo "$response" | jq -r '.data[0].unit_id')
        print_info "Unit ID yang akan digunakan: $UNIT_ID"
        return 0
    else
        print_error "Gagal mengambil data units"
        echo "Response: $response"
        return 1
    fi
}

test_get_master_data() {
    print_test "Test 3: GET Master Data (Gender, Religion, etc.)"
    increment_test
    
    local endpoints=("gender" "religions" "family-as" "education" "ocupation" "marital-statuses")
    local all_success=true
    
    for endpoint in "${endpoints[@]}"; do
        local response=$(make_request "GET" "/$endpoint/")
        local has_data=$(echo "$response" | jq -r '.data != null')
        
        if [ "$has_data" == "true" ]; then
            local count=$(echo "$response" | jq -r '.data | length')
            print_info "✓ $endpoint: $count items"
        else
            print_error "✗ $endpoint: Failed"
            all_success=false
        fi
    done
    
    if [ "$all_success" == "true" ]; then
        print_success "Semua master data berhasil diambil"
        
        # Save IDs for registration
        GENDER_ID=$(make_request "GET" "/gender/" | jq -r '.data[0].gender_id')
        RELIGION_ID=$(make_request "GET" "/religions/" | jq -r '.data[0].id')
        FAMILY_ID=$(make_request "GET" "/family-as/" | jq -r '.data[0].id')
        EDUCATION_ID=$(make_request "GET" "/education/" | jq -r '.data[0].id')
        OCCUPATION_ID=$(make_request "GET" "/ocupation/" | jq -r '.data[0].id')
        MARITAL_ID=$(make_request "GET" "/marital-statuses/" | jq -r '.data[0].id')
        
        return 0
    else
        print_error "Gagal mengambil beberapa master data"
        return 1
    fi
}

test_registration() {
    print_test "Test 4: POST Registration (Sign Up)"
    increment_test
    
    print_info "Email: $TEST_EMAIL"
    print_info "Password: $TEST_PASSWORD"
    print_info "NIK: $TEST_NIK"
    
    # Create multipart form data
    local boundary="----WebKitFormBoundary$(date +%s)"
    local data_file="/tmp/registration_data.txt"
    
    cat > "$data_file" << EOF
--${boundary}
Content-Disposition: form-data; name="email"

${TEST_EMAIL}
--${boundary}
Content-Disposition: form-data; name="password"

${TEST_PASSWORD}
--${boundary}
Content-Disposition: form-data; name="unit_id"

${UNIT_ID}
--${boundary}
Content-Disposition: form-data; name="nik"

${TEST_NIK}
--${boundary}
Content-Disposition: form-data; name="full_name"

${TEST_FULL_NAME}
--${boundary}
Content-Disposition: form-data; name="phone_no"

${TEST_PHONE}
--${boundary}
Content-Disposition: form-data; name="gender_id"

${GENDER_ID}
--${boundary}
Content-Disposition: form-data; name="date_of_birth"

1990-01-15
--${boundary}
Content-Disposition: form-data; name="religion"

${RELIGION_ID}
--${boundary}
Content-Disposition: form-data; name="place_of_birth"

Jakarta
--${boundary}
Content-Disposition: form-data; name="marital_status"

${MARITAL_ID}
--${boundary}
Content-Disposition: form-data; name="occupation"

${OCCUPATION_ID}
--${boundary}
Content-Disposition: form-data; name="education"

${EDUCATION_ID}
--${boundary}
Content-Disposition: form-data; name="family_as"

${FAMILY_ID}
--${boundary}
Content-Disposition: form-data; name="code"

${REGISTRATION_UUID}
--${boundary}--
EOF
    
    local response=$(curl -s -X POST \
        -H "Accept: application/json" \
        -H "Content-Type: multipart/form-data; boundary=${boundary}" \
        --data-binary "@${data_file}" \
        "${API_BASE_URL}/auth/sign-up/${REGISTRATION_UUID}/")
    
    local success=$(echo "$response" | jq -r '.success')
    
    if [ "$success" == "true" ]; then
        print_success "Registrasi berhasil!"
        echo "$response" | jq '.'
        return 0
    else
        print_error "Registrasi gagal"
        echo "Response: $response" | jq '.'
        return 1
    fi
}

test_login() {
    print_test "Test 5: POST Login"
    increment_test
    
    local login_data="{\"email\":\"${TEST_EMAIL}\",\"password\":\"${TEST_PASSWORD}\"}"
    local response=$(make_request "POST" "/auth/login/" "$login_data")
    
    local success=$(echo "$response" | jq -r '.success')
    
    if [ "$success" == "true" ]; then
        AUTH_TOKEN=$(echo "$response" | jq -r '.token')
        print_success "Login berhasil!"
        print_info "Token: ${AUTH_TOKEN:0:50}..."
        return 0
    else
        local message=$(echo "$response" | jq -r '.message')
        
        # Login gagal bisa jadi karena email belum verified
        if [[ "$message" == *"verif"* ]] || [[ "$message" == *"verify"* ]]; then
            print_info "Login gagal: Email belum diverifikasi (expected)"
            print_success "Test passed: System correctly blocks unverified login"
            return 0
        else
            print_error "Login gagal: $message"
            echo "Response: $response"
            return 1
        fi
    fi
}

test_resend_verification() {
    print_test "Test 6: POST Resend Verification Email"
    increment_test
    
    local data="{\"email\":\"${TEST_EMAIL}\"}"
    local response=$(make_request "POST" "/auth/verify/resend/" "$data")
    
    local success=$(echo "$response" | jq -r '.success')
    
    if [ "$success" == "true" ]; then
        print_success "Email verifikasi berhasil dikirim ulang"
        return 0
    else
        print_error "Gagal mengirim ulang email verifikasi"
        echo "Response: $response"
        return 1
    fi
}

test_invalid_code() {
    print_test "Test 7: GET Residence with Invalid Code (Negative Test)"
    increment_test
    
    local invalid_uuid="00000000-0000-0000-0000-000000000000"
    local response=$(make_request "GET" "/residence-by-code/${invalid_uuid}/")
    
    local has_data=$(echo "$response" | jq -r '.data != null')
    
    if [ "$has_data" == "false" ]; then
        print_success "System correctly rejects invalid UUID"
        return 0
    else
        print_error "System should reject invalid UUID"
        return 1
    fi
}

test_duplicate_email() {
    print_test "Test 8: POST Registration with Duplicate Email (Negative Test)"
    increment_test
    
    # Try to register with same email again
    local boundary="----WebKitFormBoundary$(date +%s)"
    local data_file="/tmp/duplicate_registration.txt"
    
    cat > "$data_file" << EOF
--${boundary}
Content-Disposition: form-data; name="email"

${TEST_EMAIL}
--${boundary}
Content-Disposition: form-data; name="password"

DifferentPassword123
--${boundary}
Content-Disposition: form-data; name="unit_id"

${UNIT_ID}
--${boundary}
Content-Disposition: form-data; name="nik"

3174010112900999
--${boundary}
Content-Disposition: form-data; name="full_name"

Duplicate Test
--${boundary}
Content-Disposition: form-data; name="phone_no"

08999999999
--${boundary}
Content-Disposition: form-data; name="gender_id"

${GENDER_ID}
--${boundary}
Content-Disposition: form-data; name="date_of_birth"

1995-05-20
--${boundary}
Content-Disposition: form-data; name="religion"

${RELIGION_ID}
--${boundary}
Content-Disposition: form-data; name="place_of_birth"

Bandung
--${boundary}
Content-Disposition: form-data; name="marital_status"

${MARITAL_ID}
--${boundary}
Content-Disposition: form-data; name="occupation"

${OCCUPATION_ID}
--${boundary}
Content-Disposition: form-data; name="education"

${EDUCATION_ID}
--${boundary}
Content-Disposition: form-data; name="family_as"

${FAMILY_ID}
--${boundary}
Content-Disposition: form-data; name="code"

${REGISTRATION_UUID}
--${boundary}--
EOF
    
    local response=$(curl -s -X POST \
        -H "Accept: application/json" \
        -H "Content-Type: multipart/form-data; boundary=${boundary}" \
        --data-binary "@${data_file}" \
        "${API_BASE_URL}/auth/sign-up/${REGISTRATION_UUID}/")
    
    local success=$(echo "$response" | jq -r '.success')
    
    if [ "$success" == "false" ]; then
        print_success "System correctly rejects duplicate email"
        return 0
    else
        print_error "System should reject duplicate email"
        echo "Response: $response"
        return 1
    fi
}

################################################################################
# Main Test Runner
################################################################################

run_all_tests() {
    print_header "PEWACA REGISTRATION TESTING - AUTOMATED"
    
    print_info "API Base URL: $API_BASE_URL"
    print_info "Registration UUID: $REGISTRATION_UUID"
    print_info "Test Email: $TEST_EMAIL"
    echo ""
    
    # Check dependencies
    check_jq
    
    # Run tests
    test_get_residence_by_code || true
    test_get_units_by_code || true
    test_get_master_data || true
    test_registration || true
    test_resend_verification || true
    test_login || true
    test_invalid_code || true
    test_duplicate_email || true
    
    # Print summary
    print_header "TEST SUMMARY"
    echo -e "Total Tests: ${TOTAL_TESTS}"
    echo -e "${GREEN}Passed: ${PASSED_TESTS}${NC}"
    echo -e "${RED}Failed: ${FAILED_TESTS}${NC}"
    
    if [ $FAILED_TESTS -eq 0 ]; then
        echo ""
        echo -e "${GREEN}✓ ALL TESTS PASSED!${NC}"
        echo ""
        exit 0
    else
        echo ""
        echo -e "${RED}✗ SOME TESTS FAILED${NC}"
        echo ""
        exit 1
    fi
}

################################################################################
# CLI Interface
################################################################################

show_help() {
    cat << EOF
PEWACA Registration Testing Script

Usage:
  ./tests/registration-test.sh [OPTIONS]

Options:
  --uuid UUID        Set registration UUID (default: $DEFAULT_UUID)
  --email EMAIL      Set test email (default: auto-generated)
  --help             Show this help message

Examples:
  # Run with default UUID
  ./tests/registration-test.sh

  # Run with custom UUID
  ./tests/registration-test.sh --uuid a1b2c3d4-e5f6-7890-abcd-ef1234567890

  # Run with custom email
  ./tests/registration-test.sh --email mytest@example.com

Requirements:
  - jq (JSON processor)
  - curl
  - bash

EOF
}

################################################################################
# Entry Point
################################################################################

# Parse command line arguments
REGISTRATION_UUID="$DEFAULT_UUID"

while [[ $# -gt 0 ]]; do
    case $1 in
        --uuid)
            REGISTRATION_UUID="$2"
            shift 2
            ;;
        --email)
            TEST_EMAIL="$2"
            shift 2
            ;;
        --help)
            show_help
            exit 0
            ;;
        *)
            echo "Unknown option: $1"
            show_help
            exit 1
            ;;
    esac
done

# Run all tests
run_all_tests
