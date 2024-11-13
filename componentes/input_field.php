<?php

class Input_field
{
    function __construct($titulo = '', $name = '', $type = '')
    {
?>
        <div class="row g-3 align-items-center mt-2 input_div">
            <div class="col-4">
                <label for="<?php echo $name; ?>" class="col-form-label text-white"><?php echo $titulo; ?></label>
            </div>
            <?php if ($type != 'textarea') { ?>
                <div class="col-8">
                    <input autocomplete="Tipea el <?php echo $titulo; ?>" require type="<?php echo $type; ?>" id="<?php echo $name; ?>" name="<?php echo $name; ?>" class="form-control rounded" aria-describedby="<?php echo $titulo; ?>">
                </div>

            <?php } else {
            ?>
                <div class="col-8">
                <textarea require class="form-control rounded" id="<?php echo $name;?>" name="<?php echo $name;?>" rows="3"></textarea>
                </div>
            <?php
            } ?>
        </div>

<?php
    }
}
