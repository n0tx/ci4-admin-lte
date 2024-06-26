<table>
    <tr>
        <?php foreach ($columns as $key => $value) : ?>
            <th><?= $key ?></th>
        <?php endforeach ?>
    </tr>
    <?php if ($data) : ?>
        <?php foreach ($data as $item) : ?>
            <tr>
                <?php foreach ($columns as $key => $value) : ?>
                    <td><?= $value($item) ?></td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    <?php else : ?>
        <tr>
            <td colspan="<?= count($columns)?>" class="text-center text-muted">
                No data yet
            </td>
        </tr>
    <?php endif ?>
</table>