<div class="page-header">
    <h2><?= t('Automatic actions for the project "%s"', $project['name']) ?></h2>
    <ul>
        <li>
            <?= $this->modal->medium('plus', t('Add a new action'), 'ActionCreationController', 'create', array('project_id' => $project['id'])) ?>
        </li>
        <li>
            <?= $this->modal->medium('copy', t('Import from another project'), 'ProjectActionDuplicationController', 'show', array('project_id' => $project['id'])) ?>
        </li>
    </ul>
</div>
<?php
/*
    echo '<pre>';
    print_r($actions);
    echo '</pre>';
*/
?>


<?php if (empty($actions)): ?>
    <p class="alert"><?= t('There is no action at the moment.') ?></p>
<?php else: ?>
    <table class="table-scrolling">
        <?php
            $last_action_name = $last_event_name  = '';
            $same_actions_div_id = $same_events_div_id = 0;
            $all_actions = new CachingIterator(new ArrayIterator ($actions), CachingIterator::TOSTRING_USE_CURRENT);
        ?>
        <?php foreach ($all_actions as $action): ?>
            <?php
                /*
                echo '<pre>';
                print_r($action);
                echo '</pre>';
                */
            ?>
            <?php if ($last_action_name != $action['action_name']): ?>
                <?php $last_action_name = $action['action_name']; ?>
                <?php $open_same_actions = TRUE; ?>
                <?php $same_actions_div_id++; ?>
                <?php if (! isset($available_params[$action['action_name']])): ?>
                    <?php $the_action_name = $this->text->e($action['action_name']); ?>
                <?php else: ?>
                    <?php $the_action_name = $this->text->in($action['action_name'], $available_actions); ?>
                <?php endif ?>
                <tr>
                    <th>
                        <div class="same_actions_head">
                            <ul>
                                <li>
                                    <span id="sameActionsToggleIcon_<?= $same_actions_div_id ?>"
                                        class="sameActionsToggleIcon"
                                        data-toggle-type="actions_"
                                        data-toggle-id="<?= $same_actions_div_id ?>">
                                        <i class="fa fa-caret-down fa-2x"></i><?= $the_action_name ?>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </th>
                </tr>
            <?php else: ?>
                <?php $open_same_actions = FALSE; ?>
            <?php endif ?>
            <?php if ($open_same_actions): ?>
                <div class="same_actions_body" id="same_actions_<?= $same_actions_div_id ?>">
            <?php endif ?>

                        <?php
                            if ($last_event_name != $action['event_name']) {
                                $last_event_name = $action['event_name'];
                                $action_id = str_replace('\\', '-', substr($action['event_name'], 1));
                        ?>
                        <tr>
                            <th>
                                <div class="actions_events" id="events_cat_<?= $action_id ?>">
                                    <ul>
                                        <li>
                                            <span id="<?= $action_id ?>"
                                                title="<?= t('Click to toggle visibilty of all automatic actions for the following event: %s', $this->text->in($action['event_name'], $available_events)); ?>"
                                                title_show = "<?= t('Right-click to show task-description') ?>"
                                                title_hide = "<?= t('Right-click to hide task-description') ?>"
                                                toggle_type="action_"
                                                toggle_id="13">
                                                    <i class="fa fa-eye"></i><?= t('Click to toggle visibilty of all automatic actions for the following event'); ?>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                        </tr>
                    <?php } ?>
            <tr>
                <th>
                    <div class="dropdown">
                        <a href="#" class="dropdown-menu dropdown-menu-link-icon"><i class="fa fa-cog"></i><i class="fa fa-caret-down"></i></a>
                        <ul>
                            <li>
                                <?= $this->modal->confirm('trash-o', t('Remove'), 'ActionController', 'confirm', array('project_id' => $project['id'], 'action_id' => $action['id'])) ?>
                            </li>
                        </ul>
                    </div>

                    <?php if (! isset($available_params[$action['action_name']])): ?>
                        <?= $this->text->e($action['action_name']) ?>
                    <?php else: ?>
                        <?= $this->text->in($action['action_name'], $available_actions) ?>
                    <?php endif ?>
                </th>
            </tr>
            <tr>
                <td>
                    <?php if (! isset($available_params[$action['action_name']])): ?>
                        <p class="alert alert-error"><?= t('Automatic action not found: "%s"', $action['action_name']) ?></p>
                    <?php else: ?>
                    <ul>
                        <li>
                            <?= t('Event name') ?> =
                            <strong><?= $this->text->in($action['event_name'], $available_events) ?></strong>
                        </li>
                        <?php foreach ($action['params'] as $param_name => $param_value): ?>
                            <li>
                                <?php if (isset($available_params[$action['action_name']][$param_name]) && is_array($available_params[$action['action_name']][$param_name])): ?>
                                    <?= $this->text->e(ucfirst($param_name)) ?> =
                                <?php else: ?>
                                    <?= $this->text->in($param_name, $available_params[$action['action_name']]) ?> =
                                <?php endif ?>
                                <strong>
                                    <?php if ($this->text->contains($param_name, 'column_id')): ?>
                                        <?= $this->text->in($param_value, $columns_list) ?>
                                    <?php elseif ($this->text->contains($param_name, 'user_id')): ?>
                                        <?= $this->text->in($param_value, $users_list) ?>
                                    <?php elseif ($this->text->contains($param_name, 'project_id')): ?>
                                        <?= $this->text->in($param_value, $projects_list) ?>
                                    <?php elseif ($this->text->contains($param_name, 'color_id')): ?>
                                        <?= $this->text->in($param_value, $colors_list) ?>
                                    <?php elseif ($this->text->contains($param_name, 'category_id')): ?>
                                        <?= $this->text->in($param_value, $categories_list) ?>
                                    <?php elseif ($this->text->contains($param_name, 'link_id')): ?>
                                        <?= $this->text->in($param_value, $links_list) ?>
                                    <?php elseif ($this->text->contains($param_name, 'swimlane_id')): ?>
                                        <?= $this->text->in($param_value, $swimlane_list) ?>
                                    <?php else: ?>
                                        <?= $this->text->e($param_value) ?>
                                    <?php endif ?>
                                </strong>
                            </li>
                        <?php endforeach ?>
                    </ul>
                    <?php endif ?>
                </td>
            </tr>
            <?php if ($all_actions->hasNext()): ?>
                <?php $next_actions = $all_actions->getInnerIterator()->current(); ?>
                <?php $next_action_name = $next_actions['action_name']; ?>
                    <?php //echo 'Next Action Name = ' . $next_action_name . '<hr>'; ?>
                <?php if ($next_action_name != $last_action_name): ?>
                    </div> <!-- closing ID same_actions_<?= $same_actions_div_id ?> -->
                <?php endif ?>
            <?php else: ?>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </table>
<?php endif ?>
