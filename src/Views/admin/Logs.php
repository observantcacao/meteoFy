<div class="container text-center mt-5 bg-dark">
    <nav aria-label="breadcrumb" class="color text-white">
        <ol class="breadcrumb color-white">
            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">logs</li>
        </ol>
    </nav>
    <h1 class="mb-4">page de logs</h1>
    <div class="container">
    <?php if (!empty($logs)) :?>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Niveau</th>
                    <th scope="col">Message</th>
                    <th scope="col">Canal</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $index => $log) : ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td>
                            <span class="badge bg-<?= Models\ActLogger::bootstrapClass($log['level_name']) ?>">
                                <?= htmlspecialchars($log['level_name']) ?>
                            </span>
                        </td>
                        <?php 
                        $datetime = new DateTime($log['datetime']);
                        $formattedTime = $datetime->format('H:i');
                        ?>
                        <td><?= htmlspecialchars($log['message']) ?></td>
                        <td><?= htmlspecialchars($log['channel']) ?></td>
                        <td><?= htmlspecialchars($formattedTime) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert alert-warning" role="alert">
            Aucun log à afficher.
        </div>
    <?php endif; ?>
    </div>
</div>