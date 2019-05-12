<div class="propery-searchSection">
        <div class="container-fluid mainWrapper listing_property">
            <form method="get" action="<?php echo base_url('listing/propertysearch'); ?>">
                <div class="msg"></div>
                <fieldset>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="searchStack">
                                <div class="iconHolder"> <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <select name="select_state" class="form-control" id="inputState">
                                        <option value="">Select Your State</option>
                                        <?php foreach ((array)volgo_get_states_by_country_id(volgo_get_user_country_id()) as $state) : ?>
                                            <option value="<?php echo $state->id; ?>" <?php if(!empty($_GET['select_state']) && $_GET['select_state'] == $state->id){echo 'selected'; } ?>><?php echo ucwords($state->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="searchStack">
                                <div class="iconHolder"> <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <select id="inputCity" <?php if(!isset($_GET['select_city'])){ ?> disabled <?php } ?> class="form-control" name="select_city" tabindex="-98">
                                    <option value="">Select Your City</option>
                                    <?php 
                                    if(isset($_GET['select_city'])){
                                        foreach($all_cities as $city){ ?>
                                        <option value="<?php echo $city->id ?>" <?php if(!empty($_GET['select_city']) && $_GET['select_city'] == $city->id){echo 'selected'; } ?>><?php echo $city->name; ?></option>
                                    <?php
                                        } 
                                      }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="textField">
                                <input type="text" class="form-control" required value="<?php if(!empty($_GET['search_query'])){ echo $_GET['search_query']; }?>" name="search_query" placeholder="Enter Neighborhood or Building e.g. Ocean Heights">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="searchStack"><span class="sidebarTitle">Select Bedrooms:</span>
                                <div class="qty"><span class="minus bg-dark">-</span>
                                    <input type="number" class="count" name="rooms" value="<?php if(!empty($_GET['rooms'])){ echo $_GET['rooms']; }else{ echo 0; }?>" min="0">
                                    <span class="plus bg-dark">+</span></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="searchStack"><span class="sidebarTitle"> Select Bath:</span>
                                <div class="qty"><span class="minus2 bg-dark">-</span>
                                    <input type="number" class="count2" name="bathrooms" value="<?php if(!empty($_GET['bathrooms'])){ echo $_GET['bathrooms']; }else{ echo 0; }?>" min="0">
                                    <span class="plus2 bg-dark">+</span></div>
                            </div>
                        </div>
                        <div class="col-md-3 manage-spaceLeft">
                            <div class="searchStack"><span class="sidebarTitle"> Select Time: </span>
                                <div class="iconHolder spl">
                                    <select class="selectpicker " multiple data-live-search="true" name="time[]" data-actions-box="true">
                                     <!-- <option value="">Please select</option> -->
                                        <option <?php if(!empty($_GET['time']) && in_array('day',$_GET['time'])){ echo 'selected';} ?> value="day">Day</option>
                                        <option <?php if(!empty($_GET['time']) && in_array('week',$_GET['time'])){ echo 'selected';} ?> value="week">Week</option>
                                        <option <?php if(!empty($_GET['time']) && in_array('month',$_GET['time'])){ echo 'selected';} ?> value="month">Month</option>
                                        <option <?php if(!empty($_GET['time']) && in_array('year',$_GET['time'])){ echo 'selected';} ?> value="year">Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="searchStack"><span class="sidebarTitle"> Select Price: </span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="textField">
                                            <input type="text" class="form-control" value="<?php if(!empty($_GET['pricefrom'])){ echo $_GET['pricefrom']; }?>" name="pricefrom" min="0" placeholder="Min. Price">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="textField">
                                            <input type="text" class="form-control" name="priceto" min="0" value="<?php if(!empty($_GET['priceto'])){ echo $_GET['priceto']; }?>" placeholder="Max. Price">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row manage-icons collapse advanceSection <?php if(array_key_exists("search_query", $_GET)){echo 'mainking';} ?>">
                        <div class="col-md-3">
                            <div class="searchStack"><span class="sidebarTitle"> Select Buy Type:</span>
                                <div class="iconHolder">
                                    <select class="form-control selectpicker" name="buyertype">
                                        <option value="">Please select</option>
                                        <option <?php if(!empty($_GET['buyertype']) && $_GET['buyertype'] == 'owner'){echo 'selected';} ?> value="owner">Owner</option>
                                        <option <?php if(!empty($_GET['buyertype']) && $_GET['buyertype'] == 'dealer'){echo 'selected';} ?> value="dealer">Dealer</option>
                                        <option <?php if(!empty($_GET['buyertype']) && $_GET['buyertype'] == 'dealership'){echo 'selected';} ?> value="dealership">Dealership/Certified Pre-Owned</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="searchStack"><span class="sidebarTitle"> Your Amenities:</span>
                                <div class="iconHolder spl">
                                    <select class="form-control selectpicker" multiple data-live-search="true" name="amenities[]"  data-actions-box="true">
                                        <option <?php if(!empty($_GET['amenities']) && in_array('air-conditioning',$_GET['amenities'])){echo 'selected';} ?> value="air-conditioning">Air Conditioning</option>
                                        <option <?php if(!empty($_GET['amenities']) && in_array('heating',$_GET['amenities'])){echo 'selected';} ?> value="heating">Heating</option>
                                        <option <?php if(!empty($_GET['amenities']) && in_array('balcony',$_GET['amenities'])){echo 'selected';} ?> value="balcony">Balcony</option>
                                        <option <?php if(!empty($_GET['amenities']) && in_array('elevator',$_GET['amenities'])){echo 'selected';} ?> value="elevator">Elevator</option>
                                        <option <?php if(!empty($_GET['amenities']) && in_array('garden',$_GET['amenities'])){echo 'selected';} ?> value="garden">Garden</option>
                                        <option <?php if(!empty($_GET['amenities']) && in_array('garage-garking',$_GET['amenities'])){echo 'selected';} ?> value="garage-garking">Garage/Parking</option>
                                        <option <?php if(!empty($_GET['amenities']) && in_array('maid-room',$_GET['amenities'])){echo 'selected';} ?> value="maid-room">Maid Room</option>
                                        <option <?php if(!empty($_GET['amenities']) && in_array('laundry-room',$_GET['amenities'])){echo 'selected';} ?> value="laundry-room">Laundry Room</option>
                                        <option <?php if(!empty($_GET['amenities']) && in_array('nearby-facilities',$_GET['amenities'])){echo 'selected';} ?> value="nearby-facilities">Nearby Facilities</option>
                                        <option <?php if(!empty($_GET['amenities']) && in_array('security',$_GET['amenities'])){echo 'selected';} ?> value="security">Security</option>
                                        <option <?php if(!empty($_GET['amenities']) && in_array('built-in-wardrobes',$_GET['amenities'])){echo 'selected';} ?> value="built-in-wardrobes">Built in Wardrobes</option>
                                        <option <?php if(!empty($_GET['amenities']) && in_array('swimming-pool',$_GET['amenities'])){echo 'selected';} ?> value="swimming-pool">Swimming Pool</option>
                                        <option <?php if(!empty($_GET['amenities']) && in_array('solar-panels',$_GET['amenities'])){echo 'selected';} ?> value="solar-panels">Solar Panels</option>
                                        <option <?php if(!empty($_GET['amenities']) && in_array('doublepane-windows',$_GET['amenities'])){echo 'selected';} ?> value="doublepane-windows">Doublepane Windows</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="searchStack"><span class="sidebarTitle"> Frunished? </span>
                                <div class="iconHolder">
                                    <select class="form-control selectpicker" name="furnished">
                                        <option value="">Please select</option>
                                        <option <?php if(!empty($_GET['furnished']) && $_GET['furnished'] == 'Furnished'){echo 'selected';} ?> value="Furnished">Furnished </option>
                                        <option <?php if(!empty($_GET['furnished']) && $_GET['furnished'] == 'Un Furnished'){echo 'selected';} ?> value="Un Furnished">Un Furnished</option>
                                        <option <?php if(!empty($_GET['furnished']) && $_GET['furnished'] == 'other'){echo 'selected';} ?> value="other">Between</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="searchStack"><span class="sidebarTitle">Area (in Sqft): </span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="textField">
                                            <input type="number" class="form-control" value="<?php if(!empty($_GET['min_area'])){ echo $_GET['min_area']; }?>" name="min_area" placeholder="Min Area">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="textField">
                                            <input type="number" class="form-control" name="max_area" value="<?php if(!empty($_GET['max_area'])){ echo $_GET['max_area']; }?>" placeholder="Max Area">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="parent_cat" class="parent_cat_name_" value="<?php echo $cat_name; ?>">
                    <input type="hidden" name="child_cats" class="child_cat_name_" disabled value="">
                    <input type="hidden" name="sorting" class="sorting" disabled value="">
                    <div class="row manage-icons">
                        <div class="search-btn col-md-3 col-lg-2">
                            <input class="search-me" type="submit" value="Search Now">
                        </div>
                        <div class="col-md-3 col-lg-2">
                            <div class="textField searchBtnsAction">
                                <button class="btn reset_search_" data-href="<?php echo base_url('category/' . $cat_name); ?>"> <i class="fa cross-icon" aria-hidden="true"></i> Reset search </button>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2">
                            <div class="textField searchBtnsAction">
                                <button class="btn save_search_"> <i class="fa fa-heart-o" aria-hidden="true"></i> save search </button>
                                <button class="btn remove_search_" style="display:none"> <i class="fa fa-heart" aria-hidden="true"></i> remove search </button>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-6"> <span class="advnc-search"><a id="advnce-ser1" data-toggle="collapse" aria-expanded="false" href="#"><i class="fa fa-plus-circle"></i>Advance Search</a></span> </div>
                    </div>
        </fieldset>
            <div class="spinner-loader-wrapper loader-wrapper" style="display: none;">
                <div class="spinner-loader fa fa-spinner fa-spin fa-2x fa-fw"></div>
            </div>
        </form>
        </div>
    </div>