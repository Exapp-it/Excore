<?php

return [
    "<ex-header />" => "<?php require(\Excore\Core\Helpers\Path::components() . 'header.php'); ?>",
    "<ex-sidebar />" => "<?php require(\Excore\Core\Helpers\Path::components() . 'sidebar.php'); ?>",
    "<ex-footer />" => "<?php require(\Excore\Core\Helpers\Path::components() . 'footer.php'); ?>",
    "<ex-toast />" => "<?php require(\Excore\Core\Helpers\Path::components() . 'toast.php'); ?>",
    "<ex-assets />" => "<?php echo \Excore\Core\Helpers\Assets::css();?>",
    "<ex-scripts />" => "<?php echo \Excore\Core\Helpers\Assets::js();?>",
    "<ex-title />" => '<?php echo $this->title;?>',
    // "<ex-csrf />" =>   '<input type="hidden" name="csrf_token" value="' . csrf() . '">'
];
