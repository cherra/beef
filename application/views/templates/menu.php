<?php
$folder = '';
$submenu = '';
$class = '';
?>

<div id="menu">
    <div class="menu">
        <?php foreach ($menu AS $opcion){ ?>
                <?php if( strlen($class) > 0 && $class != $opcion->class){ ?>
                </div>
                <?php } ?>
            <?php if( strlen($submenu) > 0 && $submenu != $opcion->submenu ) { ?>
            </div>
            <?php }?>
        <?php if(strlen($folder) > 0 && $folder != $opcion->folder){ ?>
        </div>
        <?php } ?>
                    
        <?php if($folder != $opcion->folder){ ?>
        <h3><a href="#"><?php echo ucwords($opcion->folder); ?></a></h3>
        <div class="submenu">
        <?php
        }
        ?>
            <?php if( $submenu != $opcion->submenu && strlen($opcion->submenu) > 0 ){ ?>
            <h3><a href="#"><?php echo substr(ucwords($opcion->submenu),0,16); ?></a></h3>
            <div class="submenu">
            <?php }?>
                <?php if($class != $opcion->class){ ?>
                <h3><a href="#"><?php echo substr(ucwords(str_replace('_',' ',$opcion->class)),0,16); ?></a></h3>
                <div>
                <?php
                }
                ?>
                    <div style="<?php if($opcion->menu != '1') echo "display: none;"; ?>"><?php echo anchor($opcion->folder.'/'.$opcion->class.'/'.$opcion->method,$opcion->permName); ?></div>
        <?php
        $folder = $opcion->folder;
        $submenu = $opcion->submenu;
        $class = $opcion->class;
        } 
        ?>
                </div>
            </div>
        </div>

    <div style="float: left;"><input type="checkbox" name="menu-visible" id="menu-visible" value="s"/><label for="menu-visible">Mantener visible</label></div>
</div>