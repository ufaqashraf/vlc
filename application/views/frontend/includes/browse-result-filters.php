<div class="stackHolder tags bgGrey">

    <a href="javascipt:void(0)" class="adImageLeft">
        <?php foreach (volgo_get_left_sidebar_ad_banners() as $value): ?>
            <?php if ($value->ad_type === 'image'): ?>
                <img src="<?php echo UPLOADS_URL . '/adbanners/' . $value->ad_code_image; ?>"
                     alt="Image">
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
    </a>

    <div class="browse-loader-wrapper" style="display: none;">
        <span class="fa fa-spinner fa-spin"></span>
    </div>

    <div class="row m-0">
        <div class="col-md-7 col-lg-8 pl-sm-0">
            <div class="breadcrumbHolder">
                <span>Browse result in:</span>
                <ul class="breadcrumbNav list-unstyled">
                    <li>
                                        <span href="javascript:void(0)"><?php
                                            $country_name = volgo_get_user_location();
                                            echo $country_name['country_name'];
                                            ?>
                                        </span>
                    </li>
                    <?php if (!empty($parent_cat_name)): ?>
                        <li>
                                        <span href="javascript:void(0)">
                                            <?php echo $parent_cat_name ?>
                                        </span>
                        </li>
                        <li>
                            <a class="browse-filter child" href="<?php echo base_url() . 'category/' . $parent_cat_name ?> ">
                                <?php echo $cat_name; ?>
                                <i class="fa faClose-icon" aria-hidden="true"></i>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="javascript:void(0)">
                                <?php echo $cat_name; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>

        <div class="col-md-5 col-lg-4 pr-sm-0 pl-lg-5">

            <div class="bestSeller-field">

            <span class="sortBy">Sort by:</span>
            <select class="form-control selectpicker sorting_select" name="sorting" >
                <option <?php if(!empty($_GET['sorting']) && $_GET['sorting'] == 'desc'){echo 'selected';} ?> value="desc">Newest to Oldest</option>
                <option <?php if(!empty($_GET['sorting']) && $_GET['sorting'] == 'asc'){echo 'selected';} ?> value="asc">Oldest to Newest</option>
                <option <?php if(!empty($_GET['sorting']) && $_GET['sorting'] == 'price-desc'){echo 'selected';} ?> value="price-desc">Price Highest to Lowest</option>
                <option <?php if(!empty($_GET['sorting']) && $_GET['sorting'] == 'price-asc'){echo 'selected';} ?> value="price-asc">Price Lowest to Highest</option>
            </select>

            </div>

        </div>

    </div>

</div>