<?php
class Tag extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    // Fonction pour insérer des tags en masse
    public function insertTags(array $tags)
    {
        // Supprimer les espaces autour des tags
        foreach ($tags as $key => $tag) {
            $tags[$key] = trim($tag);
        }

        // Supprimer les tags vides
        $filteredTags = [];
        foreach ($tags as $tag) {
            if (!empty($tag)) {
                $filteredTags[] = $tag;
            }
        }

        // Supprimer les doublons
        $uniqueTags = array_unique($filteredTags);

        if (!empty($uniqueTags)) {
            try {
                // Récupérer les tags existants
                $existingTags = $this->getExistingTags($uniqueTags);

                // Filtrer les nouveaux tags
                $newTags = [];
                foreach ($uniqueTags as $tag) {
                    if (!in_array($tag, $existingTags)) {
                        $newTags[] = $tag;
                    }
                }

                // Insérer les nouveaux tags
                if (!empty($newTags)) {
                    $query = "INSERT INTO tags (tag_name) VALUES (:tag_name)";
                    $stmt = $this->conn->prepare($query);

                    foreach ($newTags as $tag) {
                        $stmt->execute([':tag_name' => $tag]);
                    }

                    return [
                        'success' => true,
                        'message' => count($newTags) . " tags insérés avec succès.",
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => "Aucun nouveau tag à insérer.",
                    ];
                }
            } catch (PDOException $e) {
                return [
                    'success' => false,
                    'message' => "Erreur lors de l'insertion : " . $e->getMessage(),
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => "Aucun tag valide fourni.",
            ];
        }
    }

    // Fonction pour récupérer les tags existants
    private function getExistingTags(array $tags)
    {
        $placeholders = [];
        foreach ($tags as $key => $tag) {
            $placeholders[] = ":tag_$key";
        }

        $query = "SELECT tag_name FROM tags WHERE tag_name IN (" . implode(',', $placeholders) . ")";
        $stmt = $this->conn->prepare($query);

        foreach ($tags as $key => $tag) {
            $stmt->bindValue(":tag_$key", $tag);
        }

        $stmt->execute();
        $existingTags = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $existingTags[] = $row['tag_name'];
        }

        return $existingTags;
    }
}

