<?php $this->extend('layout.php') ?>

<?php $this->block('content') ?>
        <div class="row">
          <div class="span10">
            <h2>Main content</h2>
          </div>
          <div class="span4">
            <h3>Secondary content</h3>
          </div>
        </div>
<?php $this->endblock('content'); ?>