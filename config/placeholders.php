<?php

return [
    "<ex-header />" => "<?php require(\Excore\Core\Helpers\Path::components() . 'header.exc.php'); ?>",
    "<ex-sidebar />" => "<?php require(\Excore\Core\Helpers\Path::components() . 'sidebar.exc.php'); ?>",
    "<ex-footer />" => "<?php require(\Excore\Core\Helpers\Path::components() . 'footer.exc.php'); ?>",
    "<ex-toast />" => "<?php require(\Excore\Core\Helpers\Path::components() . 'toast.exc.php'); ?>",
    "<ex-assets />" => "<?php echo \Excore\Core\Helpers\Assets::css();?>",
    "<ex-scripts />" => "<?php echo \Excore\Core\Helpers\Assets::js();?>",
    "<ex-title />" => '<?php echo $this->title;?>',
    // "<ex-csrf />" =>   '<input type="hidden" name="csrf_token" value="' . csrf() . '">'
];
