<h1>Task list</h1>
<hr>
<div class="main">
    <div>
        <form action="/store" method="POST">
            <input type="text" class="input-task" placeholder="Enter text..." name="title" required>
            <input type="submit" class="add-task-button" value="Add task">
        </form>
        <br>
        <div class="all-buttons-section">
            <form action="/delete-all" method="POST">
                <input type="submit" class="all-button" value="Remove all">
            </form>
            <form action="/ready-all" method="POST">
                <input type="submit" class="all-button" value="Ready all">
            </form>
        </div>
    </div>
    <hr>
    <?php foreach ($tasks as $task): ?>
        <div class="task-list">
            <div>
                <h3><?php echo $task['title']; ?></h3>
                <div class="task-list">
                    <form action="/ready" method="POST">
                        <input type="hidden" name="task" value="<?php echo $task['name']; ?>">
                        <input type="submit" name="button"<?php if (!$task['status']): ?> value="Ready" <?php else: ?> value="Unready" <?php endif; ?>>
                    </form>
                    <form action="/delete" method="POST">
                        <input type="hidden" name="task" value="<?php echo $task['name']; ?>">
                        <input type="submit" name="button" value="Delete">
                    </form>
                </div>
            </div>
            <div>
                <?php if ($task['status']): ?>
                    <div class="status-circle green"></div>
                <?php else: ?>
                    <div class="status-circle red"></div>
                <?php endif; ?>
            </div>
        </div>
        <hr>
    <?php endforeach; ?>
</div>
