<?php

namespace Fifig\Volunteer\Infrastructure;

use Fifig\Volunteer\Domain\Helpers\PayloadParser;

class TallyPayloadParser implements PayloadParser
{
    private const MULTIPLE_CHOICE = 'MULTIPLE_CHOICE';
    private const CHECKBOXES = 'CHECKBOXES';
    private const MULTI_SELECT = 'MULTI_SELECT';
    private const MATRIX = 'MATRIX';

    final public function parse(string $payload): array
    {

        $rawData = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);

        $cleanData = self::cleanData($rawData['fields']);

        return self::organizeData($cleanData);
    }


    private static function cleanData(array $fields): array
    {
        return array_reduce($fields, function ($acc, $field) {
            if ($field['type'] === self::MULTIPLE_CHOICE && $field['value'] !== null) {
                return self::parseMultipleChoice($field, $acc);
            }

            if (($field['type'] === self::CHECKBOXES || $field['type'] === self::MULTI_SELECT) && $field['value'] !== null && isset($field['options'])) {
                return self::parseCheckboxesOrMultiselect($field, $acc);
            }

            if ($field['type'] === self::MATRIX && $field['value'] !== null && $field['rows'] && $field['columns']) {
                return self::parseMatrix($field, $acc);
            }

            if ($field['type'] === self::CHECKBOXES && (str_contains($field['label'], '🛠️') || str_contains($field['label'], '🧹')) && !$field['option'] && preg_match('/\(.*\)$/', $field['label'])) {
                $labelWithoutDate = preg_replace('/ \(.*\)$/', '', $field['label']);
                if (!isset($acc[$labelWithoutDate])) {
                    $acc[$labelWithoutDate] = [];
                }
                if ($field['value']) {
                    preg_match('/\((.*)\)$/', $field['label'], $matches);
                    $acc[$labelWithoutDate][] = $matches[1];
                }
                return $acc;
            }


            $acc[$field['label']] = $field['value'];
            return $acc;
        }, []);
    }

    private static function organizeData(array $cleanData): array
    {
        return array_reduce(array_keys($cleanData), function ($acc, $label) use ($cleanData) {
            $newLabel = self::getKeyMapping()[$label] ?? $label;

            if (in_array($label, self::getPersonalInformationLabels(), true)) {
                $acc['personal_informations'][$newLabel] = $cleanData[$label];
                return $acc;
            }

            if (in_array($label, self::getDisponibilityLabels(), true)) {
                $acc['disponibility'][$newLabel] = $cleanData[$label];
                return $acc;
            }

            if (in_array($label, self::getTeamLabels(), true)) {
                $acc['team'][$newLabel] = $cleanData[$label];
                return $acc;
            }

            $acc[$newLabel] = $cleanData[$label];
            return $acc;

        }, []);
    }

    private static function getKeyMapping(): array
    {
        return [
            "Prénom" => "firstName",
            "Nom" => "lastName",
            "✉️ E-mail" => "email",
            "🧑‍⚕️ Numéro de sécurité sociale" => "healthNumber",
            "📞 Téléphone" => "phoneNumber",
            "🎂Année de naissance" => "birthYear",
            "🏠 Adresse" => "address",
            "Adresse à Groix pendant le festival (si différente)" => "addressGx",
            "🆘 Personne à contacter en cas d'urgence " => "sosContact",
            "téléphone" => "sosPhone",
            " 👕 Taille T-shirt (à partir de 5 demi journées)  (XXL dispo en modèle \"homme\" seulement)" => "size",
            "🇬🇧 Niveau d'anglais" => "englishLevel",
            "🇵🇹 Niveau de portugais" => "portugeseLevel",
            "🏴‍☠️ Niveau de Breton" => "bretonLevel",
            "🥗 Quelles sont vos contraintes alimentaires ? Si vous ne cochez rien, ce sera de tout&nbsp;!" => "typeOfFood",
            "🤧 Allergies" => "allergies",
            "🥰 Avez-vous un•e ou des ami•e•s avec qui vous souhaiteriez faire partie de la même équipe, si c'est possible pour nous&nbsp;?" => "friends",
            "🚸 Si vous souhaitez bénéficier, de l'accueil de vos enfants à l’île des enfants sur vos créneaux de bénévolat, précisez leur âge:" => "childKeeping",
            "🛠️ Avant le Festival&nbsp;du vendredi 16 août au mardi 20 août : travaux divers, nettoyage, aménagement, installation expositions, mise en place et décoration du site, signalétique, secrétariat, affichage..." => "beforeEvent",
            "📢 Réunion d'accueil des bénévoles" => "volunteerMeeting",
            "🎊 Pendant le Festival du mercredi 21 août au dimanche 25 août inclus" => "duringEvent",
            "🔥En durée d'implication, vous souhaitez&nbsp;:" => "timeSlot",
            "🧹 Après le Festival lundi 28 août et mardi 29 août&nbsp;: rangement, démontage, nettoyage du site..." => "afterEvent",
            "Sélectionnez 3 équipes que vous aimeriez rejoindre (par ordre de préférences)" => "teamPreferences",
            "Choix pour la restauration" => "teamFoodChoices"
        ];
    }

    private static function getPersonalInformationLabels(): array
    {
        return ["Prénom", "Nom", "✉️ E-mail", "🧑‍⚕️ Numéro de sécurité sociale", "📞 Téléphone", "🎂Année de naissance", "🏠 Adresse", "Adresse à Groix pendant le festival (si différente)", "🆘 Personne à contacter en cas d'urgence ", "téléphone", " 👕 Taille T-shirt (à partir de 5 demi journées)  (XXL dispo en modèle \"homme\" seulement)", "🇬🇧 Niveau d'anglais", "🇵🇹 Niveau de portugais", "🏴‍☠️ Niveau de Breton", "🥗 Quelles sont vos contraintes alimentaires ? Si vous ne cochez rien, ce sera de tout&nbsp;!", "🤧 Allergies", "🥰 Avez-vous un•e ou des ami•e•s avec qui vous souhaiteriez faire partie de la même équipe, si c'est possible pour nous&nbsp;?", "🚸 Si vous souhaitez bénéficier, de l'accueil de vos enfants à l’île des enfants sur vos créneaux de bénévolat, précisez leur âge:"];
    }

    private static function getDisponibilityLabels(): array
    {
        return ["🛠️ Avant le Festival&nbsp;du vendredi 16 août au mardi 20 août : travaux divers, nettoyage, aménagement, installation expositions, mise en place et décoration du site, signalétique, secrétariat, affichage...", "📢 Réunion d'accueil des bénévoles", "🎊 Pendant le Festival du mercredi 21 août au dimanche 25 août inclus", "🔥En durée d'implication, vous souhaitez&nbsp;:", "🧹 Après le Festival lundi 28 août et mardi 29 août&nbsp;: rangement, démontage, nettoyage du site..."];
    }

    private static function getTeamLabels(): array
    {
        return ["Sélectionnez 3 équipes que vous aimeriez rejoindre (par ordre de préférences)", "Choix pour la restauration"];
    }

    private static function parseMultipleChoice(array $field, array $acc): array
    {
        $matchedOption = array_values(array_filter(
            $field['options'],
            static fn($option) => in_array($option['id'], $field['value'],
                true)
        ));
        $acc[$field['label']] = $matchedOption
            ? $matchedOption[0]['text']
            : $field['value'];
        return $acc;
    }


    private static function parseCheckboxesOrMultiselect(array $field, array $acc): array
    {
        $matchedOptions = array_values(array_filter(
            $field['options'],
            static fn($option) => in_array($option['id'], $field['value'],
                true)
        ));
        $acc[$field['label']] = count($matchedOptions) > 0
            ? array_map(static fn($option) => $option['text'], $matchedOptions)
            : $field['value'];
        return $acc;
    }

    private static function parseMatrix(array $field, array $acc): array
    {
        $matchedValues = array_map(function ($column) use ($field) {
            $matchedRows = array_filter($field['rows'], fn($row) => in_array($column['id'], $field['value'][$row['id']], true));
            return $column['text'] . ': ' . implode(', ', array_map(fn($row) => $row['text'], $matchedRows));
        }, $field['columns']
        );
        $acc[$field['label']] = $matchedValues;
        return $acc;
    }
}