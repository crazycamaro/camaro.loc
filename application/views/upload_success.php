<h3>Ваш файл был успешно загружен!</h3>

<ul>
    <?php foreach ($upload_data as $item => $value):?>
        <li><?php echo $item;?>: <?php echo $value;?></li>
    <?php endforeach; ?>
</ul>

<p><?php echo anchor('upload', 'Загрузить другой файл!'); ?></p>