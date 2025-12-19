<!-- OneSignal SDK -->
<script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
<script>
  window.OneSignalDeferred = window.OneSignalDeferred || [];
  OneSignalDeferred.push(async function(OneSignal) {
    // Check if OneSignal is configured
    const appId = "f3929e4b-b78b-40ce-8376-e1f30b883b46";
    
    if (!appId || appId === '') {
      console.warn('OneSignal App ID not configured');
      return;
    }

    await OneSignal.init({
      appId: appId,
      safari_web_id: "",
      notifyButton: {
        enable: true,
      },
      allowLocalhostAsSecureOrigin: true, // For local development
    });

    // Set external user ID from session
    @if(Session::has('warga'))
      @php
        $wargaId = Session::get('warga')['id'] ?? null;
      @endphp
      @if($wargaId)
        try {
          await OneSignal.login("{{ $wargaId }}");
          console.log('✅ OneSignal user logged in with Warga ID:', "{{ $wargaId }}");
        } catch (error) {
          console.error('❌ OneSignal login failed:', error);
        }
      @endif
    @endif

    // Listen for notification clicks
    OneSignal.Notifications.addEventListener('click', function(event) {
      console.log('OneSignal notification clicked:', event);
      
      // Get custom data
      const data = event.notification.additionalData;
      
      if (data && data.url) {
        window.location.href = data.url;
      }
    });

    // Request notification permission on user interaction
    OneSignal.Notifications.addEventListener('permissionChange', function(isSubscribed) {
      console.log('OneSignal permission changed:', isSubscribed);
    });
  });
</script>
