<?php

use Monkeycar\Helper as H;

?>
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col col-md-3">
                <h6>ИНФОРМАЦИЯ</h6>
                <ul class="list-unstyled">
                    <li><a href="dogovor.php">Договор аренды авто</a></li>
                    <li><a href="instruction-on-dtp.php">Инструкция при ДТП</a></li>
                    <li><a href="locations.php">Интересные локации</a></li>
                    <li><a href="actions.php">Акции и скидки</a></li>
                    <li><a href="prices.php">Оплата услуг</a></li>
                </ul>
            </div>
            <div class="col col-md-2">
                <h6>О НАС</h6>
                <ul class="list-unstyled">
                    <li><a href="mission.php">Миссия</li>
                    <li><a href="goals.php">Цели</li>
                    <li><a href="vacan.php">Вакансии</li>
                    <li><a href="partnership.php">Сотрудничество</li>
                </ul>
            </div>
            <div class="col-5 col-md-3">
                <ul class="list-unstyled">
                    <a href="https://g.page/r/CTEFxgyb2A7LEBM/review" class="btn btn-outline-success btn-sm">Оставить отзыв</a>
                </ul>
            </div>
            <div class="col-7 col-md-4 text-right">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="https://wa.me/66650210421" target="_blank"><span class="social icon-whatsapp"></span></a></li>
                    <li class="list-inline-item">
                        <a href="tg://resolve?domain=<@phuketservicekaron>" target="_blank"><span class="social icon-telegram"></span></a></li>
                    <li class="list-inline-item">
                        <a href="https://www.instagram.com/" target="_blank"><span class="social icon-instagram"></span></a>
                    </li>
                </ul>
                <ul class="list-unstyled">
                    <li><a href="https://wa.me/66650210421"> <span class="icon-phone"></span> +66650210421 Rus/Eng</a></li>
                    <li><span class="icon-point"></span> <a href="https://maps.app.goo.gl/kx18WyUyw1NcPhos5" target="_blank">119 Taina Rd, Karon, Mueang Phuket District, Phuket 83100</a></li>
                    <br>
                    <li><small>Copyright© 2013-2024 <br> Nightdestiny Group</small></li>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script crossorigin="anonymous" src="https://polyfill.io/v3/polyfill.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.4/dist/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@4.4/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<link rel="https://cdn.rawgit.com/mfd/f3d96ec7f0e8f034cc22ea73b3797b59/raw/856f1dbb8d807aabceb80b6d4f94b464df461b3e/gotham.css">


<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js.map"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js.map"></script>
<script>
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript" src="/assets/js/main.js?v=1"></script>
</body>
</html>
