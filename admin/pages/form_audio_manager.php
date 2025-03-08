<?php
session_start();
include '../../config/conn.php';

function getYoutubeEmbedUrl($url) {
    if (strpos($url, "youtu.be") !== false) {
        $parts = explode("/", $url);
        $id = end($parts);
        return "https://www.youtube.com/embed/" . $id;
    }
    if (strpos($url, "youtube.com") !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $query);
        if (isset($query['v'])) {
            return "https://www.youtube.com/embed/" . $query['v'];
        }
    }
    return $url;
}

$sql = "SELECT * FROM songs";
$result = $conn->query($sql);
$songs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Video</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-semibold mt-4">Quản lý Video</h2>
        <hr>

        <h3>Danh sách bài hát và video</h3>
        <a href="../../admin/includes/logic/add_audio_manager.php" class="mb-4 inline-block">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Thêm bài hát</button>
        </a>
        <table class="min-w-full bg-white rounded-lg shadow-md mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Tên bài hát</th>
                    <th class="py-2 px-4 border-b">Video</th>
                    <th class="py-2 px-4 border-b">Lời bài hát</th>
                    <th class="py-2 px-4 border-b">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($songs as $song): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b"><?php echo $song['id']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($song['title']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <?php if (!empty($song['video_file'])): ?>
                                <?php $embedUrl = getYoutubeEmbedUrl($song['video_file']); ?>
                                <iframe width="500" height="281" src="<?php echo $embedUrl; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full"></iframe>
                            <?php else: ?>
                                <p>Không có video</p>
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <div class="lyrics-container" id="lyrics-<?php echo $song['id']; ?>">
                                <?php
                                $maxLength = 100;
                                $lyrics = $song['lyrics'];
                                if (strlen($lyrics) > $maxLength) {
                                    $shortLyrics = substr($lyrics, 0, $maxLength) . '...';
                                    echo nl2br(htmlspecialchars($shortLyrics));
                                } else {
                                    echo nl2br(htmlspecialchars($lyrics));
                                }
                                ?>
                            </div>
                            <?php if (strlen($song['lyrics']) > $maxLength): ?>
                                <span class="show-more text-blue-500 cursor-pointer" onclick="toggleLyrics('<?php echo $song['id']; ?>')">Xem thêm</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <a href="../../admin/includes/logic/edit_audio_manager.php?id=<?php echo $song['id']; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded mr-2">Sửa</a>
                            <a href="delete_audio.php?id=<?php echo $song['id']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function toggleLyrics(songId) {
            const lyricsContainer = document.getElementById('lyrics-' + songId);
            lyricsContainer.classList.toggle('expanded');
            const showMore = lyricsContainer.nextElementSibling;
            if (lyricsContainer.classList.contains('expanded')) {
                showMore.textContent = 'Thu gọn';
            } else {
                showMore.textContent = 'Xem thêm';
            }
        }
    </script>
</body>
</html>