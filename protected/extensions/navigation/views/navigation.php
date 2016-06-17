<ul id="yw18" class="nav navbar-nav main-menu">
    <?php
    if (count($this->menu[top][1]) > 0) {
        foreach ($this->menu[top][1] as $menu) {
            ?>
            <li><a href="<?php echo $menu['href'] ?>"><?php echo $menu['name'] ?></a>
                <?php for ($i = 0; $i < count($menu['children']);) { ?>
                    <ul class="submenu-div <?php if ($menu['column'] > 0) { ?>col-md-<?php echo (2 * $menu['column']);
            } ?>" <?php if ($menu['column'] > 0) { ?> <?php } ?>>
                        <?php $j = $i + ceil(count($menu['children']) / $menu['column']); ?>
                        <?php for ($i = 0; $i <= $j; $i++) { ?>
                            <?php if (isset($menu['children'][$i])) { ?>
                                <li><a href="<?php echo $menu['children'][$i]['href']; ?>"><?php echo $menu['children'][$i]['name']; ?></a></li>
                            <?php } ?>

                        <?php } ?>
                    </ul>
                <?php } ?>
            </li>
        <?php }
    } ?>
    <?php if (count($this->menu[top][0]) > 0) { ?>
        <li><a style="cursor:pointer;">More</a>

            <ul class="submenu-div">
                <?php
                $i = 0;
                foreach ($this->menu[top][0] as $more) {
                    ?>
                    <li><a href="<?php echo $more['href'] ?>"><?php echo $more['name'] ?></a>
                        <ul>
                            <?php foreach ($more['children'] as $morechildren) { ?>
                                <li><a href="<?php echo $morechildren['href']; ?>"><?php echo $morechildren['name']; ?></a></li>
        <?php } ?>
                        </ul>
                    </li>
        <?php $i++;
    } ?>
            </ul>
        </li>
<?php } ?>
</ul>