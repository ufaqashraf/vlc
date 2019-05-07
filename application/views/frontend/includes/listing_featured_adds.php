<div class="featuredADs">
    <?php foreach (volgo_get_ad_banners() as $value): ?>
        <?php if ($value->ad_type === 'image'): ?>
            <div class="adBanner image-type">
                <div class="row">
                    <div class="col-md-4">
                        <a href="javascript:void(0)" class="carAdLinkHolder">
                            <img src="<?php echo UPLOADS_URL . '/adbanners/' . $value->ad_code_image; ?>" alt="Image">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="featuredAdsContent">
                            <span class="title"><?php echo $value->title; ?></span>
                            <p><?php echo $value->description; ?> </p>
                            <div class="text-left">
                                <a href="<?php echo $value->url; ?>" class="adLinkTitle">
                                    <span>Ad</span>
                                    <?php echo $value->url; ?> </a>
                            </div>
                            <div class="text-left">
                                <a href="<?php echo $value->url; ?>" class="visitwebLink"> Visit Website </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="adBanner code-type">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $value->ad_code_image; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach ?>
</div>