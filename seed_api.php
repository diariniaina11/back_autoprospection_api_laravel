<?php

function postJson($url, $data) {
    $ch = curl_init($url);
    $payload = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['code' => $httpCode, 'response' => json_decode($result, true)];
}

$baseUrl = 'http://127.0.0.1:8000/api';

echo "--- Seeding Users ---\n";
$userRes = postJson("$baseUrl/users", [
    'email' => 'contact@autoprospection.com',
    'full_name' => 'AutoProspection Admin',
    'company_name' => 'Agence Web AutoProspection'
]);
echo "User Code: {$userRes['code']}\n";
$userId = $userRes['response']['data']['id'] ?? null;

echo "--- Seeding Categories ---\n";
$categories = [
    ['name' => 'SaaS & Tech', 'description' => 'Secteur éditeurs de logiciels et technologies'],
    ['name' => 'E-commerce', 'description' => 'Boutiques en ligne et vente retail'],
    ['name' => 'Immobilier', 'description' => 'Agences et promoteurs immobiliers'],
    ['name' => 'Santé', 'description' => 'Cliniques, cabinets et santé'],
    ['name' => 'Restauration', 'description' => 'Restaurants et groupes CHR'],
    ['name' => 'Conseil & Finance', 'description' => 'Cabinets de conseil et finance'],
    ['name' => 'Industrie', 'description' => 'Entreprises industrielles et fabrication'],
];

$categoryMap = [];
foreach ($categories as $cat) {
    $res = postJson("$baseUrl/categories", $cat);
    echo "Category ({$cat['name']}) Code: {$res['code']}\n";
    if (isset($res['response']['data']['id'])) {
        $categoryMap[$cat['name']] = $res['response']['data']['id'];
    }
}

echo "--- Seeding Suspects ---\n";
$suspects = [
    ['name' => 'Audrey Deschamps', 'company' => 'Digital Connect', 'email' => 'audrey.deschamps@digitalconnect.fr', 'category_name' => 'SaaS & Tech', 'source' => 'Email', 'status' => 'en_attente', 'detected_at' => '2026-08-13 10:00:00'],
    ['name' => 'Vincent Rossi', 'company' => 'Rossi Commerce', 'email' => 'v.rossi@rossicommerce.it', 'category_name' => 'E-commerce', 'source' => 'Scraping', 'status' => 'en_attente', 'detected_at' => '2026-08-12 14:30:00'],
    ['name' => 'Claire Beaumont', 'company' => 'Immo Prestige', 'email' => 'c.beaumont@immoprestige.com', 'category_name' => 'Immobilier', 'source' => 'LinkedIn', 'status' => 'en_attente', 'detected_at' => '2026-08-12 09:15:00'],
    ['name' => 'Dr. Laurent Michelet', 'company' => 'Clinique Moderne', 'email' => 'l.michelet@clinique-moderne.fr', 'category_name' => 'Santé', 'source' => 'Scraping', 'status' => 'en_attente', 'detected_at' => '2026-08-11 16:45:00'],
    ['name' => 'Sophie Leclerc', 'company' => 'Brasserie Le Quai', 'email' => 'sophie@brasserielequai.fr', 'category_name' => 'Restauration', 'source' => 'Email', 'status' => 'en_attente', 'detected_at' => '2026-08-11 11:20:00'],
    ['name' => 'Alexis Fontaine', 'company' => 'Fontaine Finance', 'email' => 'a.fontaine@fontainefinance.com', 'category_name' => 'Conseil & Finance', 'source' => 'Scraping', 'status' => 'en_attente', 'detected_at' => '2026-08-10 15:00:00'],
    ['name' => 'Eva Richter', 'company' => 'Richter Manufacturing', 'email' => 'e.richter@richter-mfg.de', 'category_name' => 'Industrie', 'source' => 'LinkedIn', 'status' => 'en_attente', 'detected_at' => '2026-08-10 08:30:00'],
    ['name' => 'Nicolas Lefebvre', 'company' => 'TechStack Solutions', 'email' => 'n.lefebvre@techstacksolutions.fr', 'category_name' => 'SaaS & Tech', 'source' => 'Scraping', 'status' => 'en_attente', 'detected_at' => '2026-08-09 17:10:00'],
];

foreach ($suspects as $s) {
    $catId = $categoryMap[$s['category_name']] ?? null;
    unset($s['category_name']);
    $s['user_id'] = $userId;
    $s['category_id'] = $catId;
    $res = postJson("$baseUrl/suspects", $s);
    echo "Suspect ({$s['name']}) Code: {$res['code']}\n";
}

echo "--- Seeding Prospects ---\n";
$prospects = [
    ['name' => 'Camille Rousseau', 'company' => 'Nextware', 'email' => 'c.rousseau@nextware.io', 'category_name' => 'SaaS & Tech', 'source' => 'Scraping', 'status' => 'repondu', 'added_at' => '2026-08-04 10:00:00'],
    ['name' => 'Julien Marchand', 'company' => 'Boutique Lila', 'email' => 'julien@boutiquelila.fr', 'category_name' => 'E-commerce', 'source' => 'Import CSV', 'status' => 'contacte', 'added_at' => '2026-08-04 11:30:00'],
    ['name' => 'Sofia Bennani', 'company' => 'Atlas Immobilier', 'email' => 's.bennani@atlas-immo.ma', 'category_name' => 'Immobilier', 'source' => 'Manuel', 'status' => 'nouveau', 'added_at' => '2026-08-05 09:00:00'],
    ['name' => 'Marc Delaunay', 'company' => 'Clinique Verdi', 'email' => 'm.delaunay@verdi-sante.fr', 'category_name' => 'Santé', 'source' => 'Scraping', 'status' => 'relance', 'added_at' => '2026-08-05 14:15:00'],
    ['name' => 'Inès Fournier', 'company' => 'Table 21', 'email' => 'contact@table21.fr', 'category_name' => 'Restauration', 'source' => 'Scraping', 'status' => 'converti', 'added_at' => '2026-08-06 16:00:00'],
    ['name' => 'Thomas Girard', 'company' => 'Girard Conseil', 'email' => 't.girard@girard-conseil.com', 'category_name' => 'Conseil & Finance', 'source' => 'Manuel', 'status' => 'contacte', 'added_at' => '2026-08-06 10:45:00'],
    ['name' => 'Nadia El Amrani', 'company' => 'MecaPro', 'email' => 'n.elamrani@mecapro.ma', 'category_name' => 'Industrie', 'source' => 'Import CSV', 'status' => 'nouveau', 'added_at' => '2026-08-07 13:20:00'],
    ['name' => 'Pierre Lambert', 'company' => 'Cloudpeak', 'email' => 'pierre@cloudpeak.dev', 'category_name' => 'SaaS & Tech', 'source' => 'Scraping', 'status' => 'relance', 'added_at' => '2026-08-07 15:50:00'],
    ['name' => 'Léa Moreau', 'company' => 'Vestiaire Nord', 'email' => 'lea@vestiairenord.fr', 'category_name' => 'E-commerce', 'source' => 'Scraping', 'status' => 'repondu', 'added_at' => '2026-08-08 09:30:00'],
    ['name' => 'Karim Haddad', 'company' => 'Haddad Groupe', 'email' => 'k.haddad@haddadgroupe.com', 'category_name' => 'Industrie', 'source' => 'Manuel', 'status' => 'nouveau', 'added_at' => '2026-08-08 11:00:00'],
];

$prospectMap = [];
foreach ($prospects as $p) {
    $catId = $categoryMap[$p['category_name']] ?? null;
    unset($p['category_name']);
    $p['user_id'] = $userId;
    $p['category_id'] = $catId;
    $res = postJson("$baseUrl/prospects", $p);
    echo "Prospect ({$p['name']}) Code: {$res['code']}\n";
    if (isset($res['response']['data']['id'])) {
        $prospectMap[$p['name']] = $res['response']['data']['id'];
    }
}

echo "--- Seeding Cold Email Models ---\n";
$models = [
    [
        'user_id' => $userId,
        'category_id' => $categoryMap['SaaS & Tech'] ?? null,
        'name' => 'Cold Email Tech',
        'subject' => 'Une idée rapide pour améliorer votre acquisition digitale',
        'body' => "Bonjour {{prenom}},\n\nNous aidons les entreprises SaaS à améliorer leur acquisition et leur conversion sans alourdir leurs équipes internes.\n\nJ'ai repéré une opportunité concrète pour {{entreprise}}.\n\nCordialement,\nAgence Web AutoProspection",
        'is_active' => true,
    ],
    [
        'user_id' => $userId,
        'category_id' => $categoryMap['E-commerce'] ?? null,
        'name' => 'Cold Email E-commerce',
        'subject' => 'Une piste pour augmenter les ventes de {{entreprise}}',
        'body' => "Bonjour {{prenom}},\n\nJ'ai identifié un levier simple pour aider {{entreprise}} à convertir plus de visiteurs en clients.\n\nBien à vous,\nAgence Web AutoProspection",
        'is_active' => true,
    ],
    [
        'user_id' => $userId,
        'category_id' => $categoryMap['Santé'] ?? null,
        'name' => 'Cold Email Santé',
        'subject' => 'Comment améliorer la génération de demandes pour {{entreprise}}',
        'body' => "Bonjour {{prenom}},\n\nNous aidons les structures de santé à améliorer leur présence digitale...\n\nCordialement,\nAgence Web AutoProspection",
        'is_active' => true,
    ],
];

foreach ($models as $m) {
    $res = postJson("$baseUrl/cold-email-models", $m);
    echo "ColdEmailModel ({$m['name']}) Code: {$res['code']}\n";
}

echo "--- Seeding Campaigns ---\n";
$campaigns = [
    ['user_id' => $userId, 'name' => 'Prospection SaaS Q3', 'status' => 'en_cours', 'total_contacts' => 150, 'sent_count' => 120, 'failed_count' => 3],
    ['user_id' => $userId, 'name' => 'Relance E-commerce Été', 'status' => 'termine', 'total_contacts' => 80, 'sent_count' => 80, 'failed_count' => 0],
    ['user_id' => $userId, 'name' => 'Campagne Santé & Cliniques', 'status' => 'brouillon', 'total_contacts' => 45, 'sent_count' => 0, 'failed_count' => 0],
];

foreach ($campaigns as $c) {
    $res = postJson("$baseUrl/campaigns", $c);
    echo "Campaign ({$c['name']}) Code: {$res['code']}\n";
}

echo "--- Seeding Replies ---\n";
$replies = [
    [
        'prospect_id' => $prospectMap['Camille Rousseau'] ?? null,
        'category' => 'interesse',
        'subject' => 'Re: Automatiser votre prospection sortante',
        'preview' => 'Votre approche m\'intéresse, pouvons-nous échanger jeudi ?',
        'message' => "Bonjour,\n\nVotre approche m'intéresse beaucoup. Nous cherchons justement à structurer notre prospection sortante ce trimestre.\n\nPouvons-nous échanger jeudi en fin de matinée ?\n\nBien à vous,\nCamille",
        'received_at' => '2026-08-09 10:00:00',
    ],
    [
        'prospect_id' => $prospectMap['Léa Moreau'] ?? null,
        'category' => 'info',
        'subject' => 'Re: Une offre pensée pour l\'e-commerce',
        'preview' => 'Quels sont vos tarifs pour une équipe de 5 personnes ?',
        'message' => "Bonjour,\n\nMerci pour votre message. Quels sont vos tarifs pour une équipe de 5 personnes ? Et proposez-vous une période d'essai ?\n\nLéa",
        'received_at' => '2026-08-09 07:00:00',
    ],
    [
        'prospect_id' => $prospectMap['Marc Delaunay'] ?? null,
        'category' => 'a_relancer',
        'subject' => 'Re: Gagner du temps sur vos prises de contact',
        'preview' => 'Recontactez-moi en septembre, période chargée actuellement.',
        'message' => "Bonjour,\n\nPériode chargée pour nous. Recontactez-moi début septembre.\n\nCordialement,\nMarc",
        'received_at' => '2026-08-08 14:00:00',
    ],
    [
        'prospect_id' => $prospectMap['Julien Marchand'] ?? null,
        'category' => 'pas_interesse',
        'subject' => 'Re: Proposition de collaboration',
        'preview' => 'Merci, ce n\'est pas une priorité pour nous cette année.',
        'message' => "Bonjour,\n\nMerci pour votre message mais ce n'est pas une priorité cette année.\n\nJulien",
        'received_at' => '2026-08-08 11:30:00',
    ],
];

foreach ($replies as $r) {
    $res = postJson("$baseUrl/replies", $r);
    echo "Reply ({$r['subject']}) Code: {$res['code']}\n";
    $replyId = $res['response']['data']['id'] ?? null;
    if ($replyId) {
        postJson("$baseUrl/message-threads", [
            'reply_id' => $replyId,
            'sender' => 'prospect',
            'text' => $r['message'],
            'sent_at' => $r['received_at'],
        ]);
    }
}

echo "--- Seeding FollowUps ---\n";
$followUps = [
    [
        'prospect_id' => $prospectMap['Marc Delaunay'] ?? null,
        'step' => 'Relance 1 (J+3)',
        'status' => 'scheduled',
        'template_subject' => 'Avez-vous eu le temps de jeter un œil ?',
        'template_body' => 'Bonjour, je reviens vers vous pour savoir si mon précédent message a retenu votre attention.',
        'scheduled_at' => '2026-08-15 09:00:00',
    ],
    [
        'prospect_id' => $prospectMap['Pierre Lambert'] ?? null,
        'step' => 'Relance 2 (J+7)',
        'status' => 'pending',
        'template_subject' => 'Dernier petit mot concernant Cloudpeak',
        'template_body' => 'Bonjour, je me permet une relance rapide concernant l\'optimisation de vos conversions.',
        'scheduled_at' => '2026-08-20 09:00:00',
    ],
];

foreach ($followUps as $f) {
    $res = postJson("$baseUrl/follow-ups", $f);
    echo "FollowUp ({$f['step']}) Code: {$res['code']}\n";
}

echo "--- Seeding AI Usage Credits ---\n";
$res = postJson("$baseUrl/ai-usage-credits", [
    'user_id' => $userId,
    'credits_allocated' => 1000,
    'credits_used' => 340,
    'last_reset_at' => '2026-08-01 00:00:00',
]);
echo "AiUsageCredits Code: {$res['code']}\n";

echo "Seeding completed successfully!\n";
