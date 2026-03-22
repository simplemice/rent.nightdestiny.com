<?php
    use \Monkeycar\Helper as H;
?>
                            <div class="col-md-12 col-lg-5 car-img">
         			<a href="/assets/images/<?=$car['image']?>" data-toggle="lightbox"><img src="/assets/images/<?=$car['image']?>" class="img-fluid"></a>
				<?php if ($_calcPrice['discountPercentage']): ?>
                                    <div class="promotion">
                                        <span class="badge badge-danger"><?=H::t('car:discount')?> -<?=$_calcPrice['discountPercentage']?>%</span>
                                    </div>
                                <?php endif ?>
                            </div>

                            <div class="col-auto mr-auto car-info">
                                <h5>
                                    <?=$car['model']?>
                                    <small class="text-muted"> <strong><?=$car['engine']?></strong></small>
                                </h5>
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
