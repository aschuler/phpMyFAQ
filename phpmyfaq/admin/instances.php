<?php
/**
 * The main multi-site instances frontend
 *
 * PHP 5.3
 *
 * This Source Code Form is subject to the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at http://mozilla.org/MPL/2.0/.
 *
 * @category  phpMyFAQ
 * @package   Administration
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2012 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      http://www.phpmyfaq.de
 * @since     2012-03-16
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}
?>
    <header>
        <h2><?php print $PMF_LANG['ad_menu_instances']; ?></h2>
        <?php if ($permission['addinstances']): ?>
        <div>
            <a class="btn btn-primary" data-toggle="modal" href="#pmf-modal-add-instance">add new phpMyFAQ site</a>
        </div>
        <?php endif; ?>
    </header>
<?php
if ($permission['editinstances']) {

    $instance   = new PMF_Instance($faqConfig);
    $instanceId = PMF_Filter::filterInput(INPUT_POST, 'instance_id', FILTER_VALIDATE_INT);

    // Check, if /multisite is writeable
    if (! is_writable(PMF_ROOT_DIR . DIRECTORY_SEPARATOR . 'multisite')) {
        print '<p class="alert alert-error">The folder /multisite isn\'t writable.</p>';
    }

    // Update client instance
    if ('updateinstance' === $action && is_integer($instanceId)) {

        $system         = new PMF_System();
        $clientInstance = new PMF_Instance_Client($faqConfig);

        // Collect data for database
        $data = array();
        $data['instance'] = PMF_Filter::filterInput(INPUT_POST, 'instance', FILTER_SANITIZE_STRING);
        $data['comment']  = PMF_Filter::filterInput(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

        if ($clientInstance->updateInstance($instanceId, $data)) {
            printf(
                '<p class="alert alert-success">%s%s</p>',
                '<a class="close" data-dismiss="alert" href="#">&times;</a>',
                $PMF_LANG['ad_config_saved']
            );
        } else {
            printf(
                '<p class="alert alert-error">%s%s<br/>%s</p>',
                '<a class="close" data-dismiss="alert" href="#">&times;</a>',
                $PMF_LANG['ad_entryins_fail'],
                $faqConfig->getDb()->error()
            );
        }
    }
?>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>URL</th>
            <th>Instance</th>
            <th colspan="4">site name</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($instance->getAllInstances() as $site):
            $currentInstance = new PMF_Instance($faqConfig);
            $currentInstance->getInstanceById($site->id);
            $currentInstance->setId($site->id);
        ?>
        <tr id="row-instance-<?php print $site->id ?>">
            <td><?php print $site->id ?></td>
            <td><a href="<?php print $site->url . $site->instance ?>"><?php print $site->url ?></a></td>
            <td><?php print $site->instance ?></td>
            <td><?php print $site->comment ?></td>
            <td>
                <?php if (! $currentInstance->getConfig('isMaster') === true): ?>
                <a href="?action=editinstance&instance_id=<?php print $site->id ?>" class="btn btn-info">edit</a>
                <?php endif; ?>
            </td>
            <td>
                <?php if (! $currentInstance->getConfig('isMaster') === true): ?>
                <a href="javascript:;" id="delete-instance-<?php print $site->id ?>"
                   class="btn btn-danger pmf-instance-delete">delete</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="modal fade" id="pmf-modal-add-instance">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>Add new phpMyFAQ site</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" action="#" method="post">
                <div class="control-group">
                    <label class="control-label"><?php print $PMF_LANG['ad_stat_report_url'] ?>:</label>
                    <div class="controls">
                        <div class="input-prepend input-append">
                            <span class="add-on">http://</span>
                            <input class="span2" type="text" name="url" id="url" required="required">
                            <span class="add-on">.<?php print $_SERVER['SERVER_NAME'] ?></span>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Name of Instance:</label>
                    <div class="controls">
                        <input type="text" name="instance" id="instance" required="required">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Comment:</label>
                    <div class="controls">
                        <input type="text" name="comment" id="comment" required="required">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">Your email address:</label>
                    <div class="controls">
                        <input type="email" name="email" id="email" required="required" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Admin loginname:</label>
                    <div class="controls">
                        <input type="text" name="admin" id="admin" required="required">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="password">Your password:</label>
                    <div class="controls">
                        <input type="password" name="password" id="password" required="required" />
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <p>Caution: This will create a new phpMyFAQ instance!</p>
            <a href="javascript:;" class="btn btn-primary pmf-instance-add">Save changes</a>
        </div>
    </div>

    <script type="text/javascript">
        // Add instance
        $('.pmf-instance-add').click(function(event) {
            event.preventDefault();
            var url      = $('#url').val();
            var instance = $('#instance').val();
            var comment  = $('#comment').val();
            var email    = $('#email').val();
            var admin    = $('#admin').val();
            var password = $('#password').val();

            $.get('index.php',
                { action: 'ajax', ajax: 'config', ajaxaction: 'add_instance',
                  url: url, instance: instance, comment: comment, email: email, admin: admin, password: password
                },
                function(data) {
                    if (typeof(data.added) === 'undefined') {
                        $('.table').after(
                            '<div class="alert alert-error">Could not add instance</div>'
                        );
                    } else {
                        $('.modal').modal('hide');
                        $('.table tbody').append(
                            '<tr id="row-instance-' + data.added + '">' +
                            '<td>' + data.added + '</td>' +
                            '<td><a href="' + data.url + '">' + data.url + '</a></td>' +
                            '<td>' + instance + '</td>' +
                            '<td>' + comment + '</td>' +
                            '<td>' +
                            '<a href="?action=editinstance&instance_id=' + data.added +
                            '" class="btn btn-info">edit</a>' +
                            '</td>' +
                            '<td>' +
                            '<a href="javascript:;" id="delete-instance-' + data.added +
                            '" class="btn btn-danger pmf-instance-delete">delete</a>' +
                            '</td>' +
                            '</tr>'
                        );
                    }
                },
                'json'
            );

        });

        // Delete instance
        $('.pmf-instance-delete').click(function(event) {
            event.preventDefault();
            var targetId = event.target.id.split('-');
            var id = targetId[2];

            if (confirm('Are you sure?')) {
                $.get('index.php',
                    { action: 'ajax', ajax: 'config', ajaxaction: 'delete_instance', instanceId: id },
                    function(data) {
                        if (typeof(data.deleted) === 'undefined') {
                            $('.table').after(
                                '<div class="alert alert-error">Could not delete instance ' + data.error +'</div>'
                            );
                        } else {
                            $('#row-instance-' + id).fadeOut('slow');
                        }
                    },
                    'json'
                );
            }
        });
    </script>
<?php
} else {
    print $PMF_LANG['err_NotAuth'];
}