<?php

use Monkeycar\Helper as H;

?>
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col col-md-3">
                <h6>ИНФОРМАЦИЯ</h6>
                <ul class="list-unstyled">
                    <li><a href="#modal-conditions" data-toggle="modal" data-target="#modal-conditions">Условия аренды авто</a></li>
                    <li><a href="/">Каталог автомобилей</a></li>
                </ul>
            </div>
            <div class="col col-md-2">
                <h6>КОНТАКТЫ</h6>
                <ul class="list-unstyled">
                    <li><a href="https://wa.me/66942654121" data-track="whatsapp" target="_blank" rel="noopener">WhatsApp</a></li>
                    <li><a href="https://t.me/simplemice" target="_blank" rel="noopener">Telegram</a></li>
                </ul>
            </div>
            <div class="col-5 col-md-3">
                <ul class="list-unstyled">
                    <a href="https://g.page/nightdestiny?gm" target="_blank" rel="noopener" class="btn btn-outline-success btn-sm">Оставить отзыв</a>
                </ul>
            </div>
            <div class="col-7 col-md-4 text-right">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="https://wa.me/66942654121" data-track="whatsapp" target="_blank" rel="noopener" aria-label="WhatsApp"><span class="social icon-whatsapp"></span></a></li>
                    <li class="list-inline-item">
                        <a href="https://t.me/simplemice" target="_blank" rel="noopener" aria-label="Telegram"><span class="social icon-telegram"></span></a></li>
                    <li class="list-inline-item">
                        <a href="https://www.instagram.com/simplemice_" target="_blank" rel="noopener" aria-label="Instagram"><span class="social icon-instagram"></span></a>
                    </li>
                </ul>
                <ul class="list-unstyled">
                    <li><a href="tel:+66942654121" data-track="phone"> <span class="icon-phone"></span> +66942654121 Rus/Eng</a></li>
                    <li><span class="icon-point"></span> <a href="https://maps.app.goo.gl/kx18WyUyw1NcPhos5" target="_blank" rel="noopener">Mueang Phuket District, Phuket 83100</a></li>
                    <br>
                    <li><small>Copyright© 2018-2026 <br> Nightdestiny Co.,Ltd</small></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<!-- Large modal -->
<div id="modal-conditions" class="modal fade bd-terms-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="icon-second-doc"></span>
                    <strong><?=H::t('car-terms-conditions')?></strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <div class="row">
                    <div class="col-auto mr-auto">
                        <h6><strong><?=H::t('car-terms')?></strong></h6>
                    </div>
                    <div class="col-auto">
                        <a type="button" data-toggle="collapse" data-target="#car-terms" aria-expanded="false" aria-controls="car-terms">+</a>
                    </div>
                </div>
                <div class="collapse" id="car-terms">
                    <?=H::t('car-terms-list')?>
                </div>
                <hr>
                <div class="row">
                    <div class="col-auto mr-auto">
                        <h6><strong><?=H::t('car-conditions')?></strong></h6>
                    </div>
                    <div class="col-auto">
                        <a type="button" data-toggle="collapse" data-target="#car-conditions" aria-expanded="false" aria-controls="car-conditions">+</a>
                    </div>
                </div>
                <div class="collapse" id="car-conditions">
                    <?=H::t('car-conditions-list')?>
                </div>
                <hr>
                <div class="row">
                    <div class="col-auto mr-auto">
                        <h6><strong><?=H::t('car-use')?></strong></h6>
                    </div>
                    <div class="col-auto">
                        <a type="button" data-toggle="collapse" data-target="#car-use" aria-expanded="false" aria-controls="car-use">+</a>
                    </div>
                </div>
                <div class="collapse" id="car-use">
                    <?=H::t('car-use-list')?>
                </div>
                <hr>
                <div class="row">
                    <div class="col-auto mr-auto">
                        <h6><strong><?=H::t('car-tenant')?></strong></h6>
                    </div>
                    <div class="col-auto">
                        <a type="button" data-toggle="collapse" data-target="#car-tenant" aria-expanded="false" aria-controls="car-tenant">+</a>
                    </div>
                </div>
                <div class="collapse" id="car-tenant">
                    <?=H::t('car-tenant-list')?>
                </div>
            </div>
        </div>
    </div>
</div>

</section>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script>
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="/assets/js/main.js?v=2"></script>
</body>
</html>
