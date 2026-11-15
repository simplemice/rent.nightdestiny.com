<?php
    use \Monkeycar\Helper as H;
?>
                            <div class="col-md-12 col-lg-5 car-img">
         			<a href="/assets/images/<?=H::e(rawurlencode($car['image']))?>" data-toggle="lightbox" aria-label="<?=H::e(H::carName($car))?> — увеличить фото"><?=H::picture($car['image'], H::carName($car).' — аренда на Пхукете', !empty($_eagerImage))?></a>
				<?php if ($_calcPrice['discountPercentage']): ?>
                                    <div class="promotion">
                                        <span class="badge badge-danger"><?=H::t('car:discount')?> -<?=$_calcPrice['discountPercentage']?>%</span>
                                    </div>
                                <?php endif ?>
                            </div>

                            <div class="col-auto mr-auto car-info">
                                <?php $_h = $_carHeading ?? 'h3'; ?>
                                <<?=$_h?> class="h5">
                                    <?php if ($_h === 'h3'): ?><a class="text-reset" href="<?=H::e($_carLink ?? H::carPath($car['id']))?>"><?=H::e(H::carName($car))?></a><?php else: ?><?=H::e(H::carName($car))?><?php endif ?>
                                    <small class="text-muted"> <strong><?=H::e($car['engine'])?></strong></small>
                                </<?=$_h?>>
                                <ul class="list-unstyled">
                                    <li>
                                        <span class="icon-transmission"></span> <?=H::t('car:transmission')?>
                                    </li>
                                    <li>
                                        <span class="icon-snow"></span> <?=H::t('car:ac')?>
                                    </li>
                                    <li>
                                        <span class="icon-calendar"></span> <?=$car['year']?><?=H::t('car:year')?>
                                    </li>
                                    <li>
                                        <span class="icon-fuel"></span> <?=$car['fuel']?> | <?=$car['consumption']?>
                                    </li>
                                    <li>
                                        <span class="icon-music"></span> <?=$car['multimedia']?>
                                    </li>
                                    <li>
                                        <span class="icon-user"></span> <?=$car['seats']?> <?=H::t('car:seats')?>
                                    </li>
                                </ul>
                            </div>
