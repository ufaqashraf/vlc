<div class="col-md-4 col-lg-3 new-sidebar">
    <div class="sidebarSearch">
        <div class="holder">
            <h2>Popular Searches</h2>
            <ul class="search-links">
                <?php 
                    if(!empty($popular_searches)):
                        foreach($popular_searches as $search):
                            echo '<li><a href="'.base_url().$search->search_query.'">'.$search->query_title.'</a></li>';
                        endforeach;
                    else:
                        echo '<li><h4>Items not found to your location</h4></li>';
                    endif;
                ?>
            </ul>

        </div>
    </div>

    <div class="sidebarSearch">
        <div class="holder">
            <h2>Nearby Areas</h2>
            <ul class="search-links">
                <?php 
                    if(!empty($nearby)):
                        foreach($nearby as $item): ?>
                            <li><a href="<?php echo base_url().$item->slug; ?>"><?php echo substr($item->title,0,35).'...'; ?></a></li>
                <?php 
                        endforeach;
                    else:
                            echo '<li><h4>Items not found to your location</h4></li>';
                    endif;
                ?>
            </ul>

        </div>
    </div>
</div>