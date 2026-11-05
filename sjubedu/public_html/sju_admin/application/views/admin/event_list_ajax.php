<?php
$no_of_pages = ceil($count / $per_page);
?>

<?php if (!empty($events)): ?>
    <?php foreach ($events as $row): ?>

        <?php
        $created_at = $row->created_at
            ? date('d-m-Y h:i A', strtotime($row->created_at))
            : '-';

        $event_date = $row->event_date
            ? date('d-m-Y', strtotime($row->event_date))
            : '-';

        if ($row->c_status == 'Y') {
            $cst = 'success';
            $cstat = 'Active';
            $tit = 'Click to Disable';
        } else {
            $cst = 'danger';
            $cstat = 'Disabled';
            $tit = 'Click to make Active';
        }
        ?>

        <tr>
            <td><?= $row->event_name ?></td>
            <td><?= $row->description ?></td>
            <td><?= $event_date ?></td>
            <td><?= $created_at ?></td>
            <td>
                <span class="label label-primary editdetail hnd" id="<?= $row->id ?>">
                    <i class="fa fa-edit"></i> Edit
                </span>

                <span id="cr_<?= $row->id ?>"
                      title="<?= $tit ?>"
                      class="hnd statusdiv label label-<?= $cst ?>">
                    <?= $cstat ?>
                </span>
            </td>
        </tr>

    <?php endforeach; ?>

    <tr>
        <td colspan="5">
            <?php $this->load->view('admin/pagination', [
                'page' => $page,
                'pages'=> $no_of_pages
            ]); ?>
        </td>
    </tr>

<?php else: ?>
    <tr>
        <td colspan="5">No data found</td>
    </tr>
<?php endif; ?>
