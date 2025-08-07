<div class="flex justify-center items-center" style="height: 100%;">
                    <div class="bg-white w-full max-w-6xl">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                <strong>Pembayaran sampah dan keamanan</strong>
                                </p>
                            </div>
                
                            <div class="flex items-center">
                                <?php if ("wajib" == "wajib"){
                                        $col = 'red';
                                    }else{
                                        $col = 'lightgreen';
                                    }
                                ?>
                                <p class="d-flex align-items-center" style="color:<?php echo $col;?>">
                                <strong>Wajib</strong>
                                </p>
                            </div>
                        </div>  
                    
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                    deskripsi dummy
                                </p>
                            </div>
                        </div> 
                        <div class="flex justify-between items-center mt-1">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                Nominal
                                </p>
                            </div>
                            
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                    @php
                                        $formattedAmount = 'Rp ' . number_format(150000, 0, ',', '.');
                                    @endphp
                                    {{ $formattedAmount }}
                                </p>
                            </div>
                        </div> 
                    
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                Terakhir Pembayaran
                                </p>
                            </div>
                            
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                    12 Agustus 2025
                                
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                    Periode
                                </p>
                            </div>
                            
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                    Agustus
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                               
                
                <div class="flex justify-between items-center mt-2">
                    <div class="flex items-center">
                        <p class="text-warning d-flex align-items-center">
                            
                        </p>
                    </div>
                    @if('unpaid'== 'unpaid')
                        <div class="flex items-right">
                            @if('wajib' != 'wajib')
                            <a href="#" class="btn btn-sm btn-light w-20" style="border-radius:8px;">Tidak</a>
                            @endif
                            &nbsp;&nbsp;
                            <a href="{{ route('pembayaran.pembayaran_periode') }}" class="btn btn-sm btn-success w-20 btn-publish" style="color: white;border-radius:8px;">Bayar</a>
                        </div>
                    @else
                        <div class="flex items-right">
                            &nbsp;&nbsp;
                            <a href="{{ route('pembayaran.detail_bukti', ['id' => 1]) }}" class="btn btn-sm btn-success w-20 btn-publish" style="color: white;border-radius:8px;">Detail</a>
                        </div>
                    @endif
                </div>
                <hr class="mt-3 mb-2">
              