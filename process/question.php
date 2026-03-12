<?php
// process/question.php
require_once "../utils/db_connect.php";
header('Content-Type: application/json');

// Usiamo "id" perché nel tuo link c'è ?id=1
$quiz_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($quiz_id === 0) {
    echo json_encode(["error" => "ID quiz non valido"]);
    exit();
}

try {
    // La query deve avere il segnaposto :quiz_id
    $sql = "SELECT q.id as question_id, q.question_text, a.answer_text, a.is_correct
            FROM question q
            JOIN answer a ON a.question_id = q.id
            WHERE q.quiz_id = :quiz_id
            ORDER BY q.id ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':quiz_id' => $quiz_id]); // Il nome deve coincidere con :quiz_id nella query
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(["error" => "Errore SQL: " . $e->getMessage()]);
}