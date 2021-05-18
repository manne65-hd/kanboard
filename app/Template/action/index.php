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

<?php if (empty($actions)): ?>
    <p class="alert"><?= t('There is no action at the moment.') ?></p>
<?php else: ?>
    <table class="table-scrolling">
        <tr>
            <td class="automatic-actions-list">
                <?php $current_action_name = $actions[0]['action_name']; ?>
                <?php $current_event_name = $actions[0]['event_name']; ?>
                <?php $same_actions_id = $same_events_id = 1; ?>
                <?php if (! isset($available_params[$actions[0]['action_name']])): ?>
                    <?php $current_action_title = $this->text->e($actions[0]['action_name']) ?>
                <?php else: ?>
                    <?php $current_action_title = $this->text->in($actions[0]['action_name'], $available_actions) ?>
                <?php endif ?>
                <?php $current_event_title = $this->text->in($actions[0]['event_name'], $available_events) ?>
                <?php $all_actions = new CachingIterator(new ArrayIterator ($actions), CachingIterator::TOSTRING_USE_CURRENT); ?>
                <div id="same-actions-toggle-header_<?= $same_actions_id ?>"
                    class="same-category-header same-actions same-actions-first"
                    title="<?= t('Click to collapse all actions of type: "%s"', $current_action_title) ?>"
                    data-toggle-type="actions"
                    data-title-collapse= "<?= t('Click to collapse all actions of type: "%s"', $current_action_title) ?>"
                    data-title-expand= "<?= t('Click to expand all actions of type: "%s"', $current_action_title) ?>"
                    data-toggle-id="<?= $same_actions_id ?>">
                        <i id="same-actions-toggle-icon_<?= $same_actions_id ?>" class="fa fa-caret-right actions-toggle-icon"></i><?= $current_action_title . ' ...' ?>
                </div>
                <div id="same-actions-body_<?= $same_actions_id ?>" class="same-actions-body">
                    <div id="same-events-toggle-header_<?= $same_events_id ?>"
                        class="same-category-header same-events"
                        title="<?= t('Click to collapse all events of type: "%s" for the current action-type', $current_event_title) ?>"
                        data-toggle-type="events"
                        data-title-collapse= "<?= t('Click to collapse all events of type: "%s" for the current action-type', $current_event_title) ?>"
                        data-title-expand= "<?= t('Click to expand all events of type: "%s" for the current action-type', $current_event_title) ?>"
                        data-toggle-id="<?= $same_events_id ?>">
                            <i id="same-events-toggle-icon_<?= $same_events_id ?>" class="fa fa-caret-down actions-toggle-icon"></i><?= $current_event_title . ' ...' ?>
                    </div>
                    <div id="same-events-body_<?= $same_events_id ?>" class="same-events-body">
                        <div class="current-automatic-actions">
                            <?php foreach ($all_actions as $action): ?>
                            <div class="current-automatic-action">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-menu dropdown-menu-link-icon automatic-actions-dropdown-menu"><i class="fa fa-cog"></i><i class="fa fa-caret-down actions-toggle-icon"></i></a>
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
                            </div>
                            <div class="current-automatic-action-params">
                                    <?php if (! isset($available_params[$action['action_name']])): ?>
                                        <p class="alert alert-error"><?= t('Automatic action not found: "%s"', $action['action_name']) ?></p>
                                    <?php else: ?>
                                    <ul class="automatic-actions-params">
                                        <li class="automatic-actions-params">
                                            <?= t('Event name') ?> =
                                            <strong><?= $this->text->in($action['event_name'], $available_events) ?></strong>
                                        </li>
                                        <?php foreach ($action['params'] as $param_name => $param_value): ?>
                                            <li class="automatic-actions-params">
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
                            </div>
                    <?php if ($all_actions->hasNext()): ?>
                        <?php $next_action = $all_actions->getInnerIterator()->current(); ?>
                        <?php if($next_action['action_name'] != $current_action_name): ?>
                            <?php $current_event_name = $next_action['event_name'] ?>
                            <?php $current_action_name = $next_action['action_name'] ?>
                                    </div>
                                </div><!-- closing same_events_body_<?= $same_events_id ?> -->
                            </div><!-- closing same_actions_body_<?= $same_actions_id ?> -->
                            <?php $same_events_id++; ?>
                            <?php $same_actions_id++; ?>
                            <?php if (! isset($available_params[$next_action['action_name']])): ?>
                                <?php $current_action_title = $this->text->e($next_action['action_name']) ?>
                            <?php else: ?>
                                <?php $current_action_title = $this->text->in($next_action['action_name'], $available_actions) ?>
                            <?php endif ?>
                            <?php $current_event_title = $this->text->in($next_action['event_name'], $available_events) ?>
                            <div id="same-actions-toggle-header_<?= $same_actions_id ?>"
                                class="same-category-header same-actions"
                                title="<?= t('Click to collapse all actions of type: "%s"', $current_action_title) ?>"
                                data-toggle-type="actions"
                                data-title-collapse= "<?= t('Click to collapse all actions of type: "%s"', $current_action_title) ?>"
                                data-title-expand= "<?= t('Click to expand all actions of type: "%s"', $current_action_title) ?>"
                                data-toggle-id="<?= $same_actions_id ?>">
                                    <i id="same-actions-toggle-icon_<?= $same_actions_id ?>" class="fa fa-caret-right actions-toggle-icon"></i><?= $current_action_title . ' ...' ?>
                            </div>
                            <div id="same-actions-body_<?= $same_actions_id ?>" class="same-actions-body">
                                <div id="same-events-toggle-header_<?= $same_events_id ?>"
                                    class="same-category-header same-events"
                                    title="<?= t('Click to collapse all events of type: "%s" for the current action-type', $current_event_title) ?>"
                                    data-toggle-type="events"
                                    data-title-collapse= "<?= t('Click to collapse all events of type: "%s" for the current action-type', $current_event_title) ?>"
                                    data-title-expand= "<?= t('Click to expand all events of type: "%s" for the current action-type', $current_event_title) ?>"
                                    data-toggle-id="<?= $same_events_id ?>">
                                        <i id="same-events-toggle-icon_<?= $same_events_id ?>" class="fa fa-caret-down actions-toggle-icon"></i><?= $current_event_title . ' ...' ?>
                                </div>
                                <div id="same-events-body_<?= $same_events_id ?>" class="same-events-body">
                                    <div class="current-automatic-actions">
                        <?php elseif($next_action['event_name'] != $current_event_name): ?>
                            <?php $current_event_name = $next_action['event_name'] ?>
                                </div>
                            </div><!-- closing same_events_body_<?= $same_events_id ?> -->
                            <?php $same_events_id++; ?>
                            <?php $current_event_title = $this->text->in($next_action['event_name'], $available_events) ?>
                            <div id="same-events-toggle-header_<?= $same_events_id ?>"
                                class="same-category-header same-events"
                                title="<?= t('Click to collapse all events of type: "%s" for the current action-type', $current_event_title) ?>"
                                data-toggle-type="events"
                                data-title-collapse= "<?= t('Click to collapse all events of type: "%s" for the current action-type', $current_event_title) ?>"
                                data-title-expand= "<?= t('Click to expand all events of type: "%s" for the current action-type', $current_event_title) ?>"
                                data-toggle-id="<?= $same_events_id ?>">
                                    <i id="same-events-toggle-icon_<?= $same_events_id ?>" class="fa fa-caret-down actions-toggle-icon"></i><?= $current_event_title . ' ...' ?>
                            </div>
                            <div id="same-events-body_<?= $same_events_id ?>" class="same-events-body">
                                <div class="current-automatic-actions">
                        <?php endif ?>
                    <?php else: ?>
                        </div></div></div>
                    <?php endif ?>
                <?php endforeach ?>
            </td>
        </tr>
    </table>
<?php endif ?>
