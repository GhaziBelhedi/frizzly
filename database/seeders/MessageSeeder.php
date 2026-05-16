<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'sender_name' => 'Amira Bensalem',
                'email'       => 'amira@ecole.tn',
                'phone'       => '+216 71 234 567',
                'subject'     => 'Demande de démonstration',
                'message'     => 'Bonjour, je suis directrice dans une école primaire à Tunis. Je souhaiterais organiser une démonstration du Frizzly Kit pour mon équipe pédagogique d\'une quinzaine d\'enseignants. Pouvez-vous me contacter pour convenir d\'un rendez-vous ? Merci beaucoup.',
                'status'      => 'unread',
                'reply'       => null,
                'days'        => 0,
                'hours'       => 2,
            ],
            [
                'sender_name' => 'Karim Trabelsi',
                'email'       => 'karim@gmail.com',
                'phone'       => '+216 20 345 678',
                'subject'     => 'Question sur le programme certifiant',
                'message'     => 'Bonjour, j\'ai découvert Frizzly sur les réseaux sociaux. J\'aimerais savoir si le programme certifiant est reconnu par le ministère de l\'éducation. Merci de m\'éclairer sur ce point.',
                'status'      => 'unread',
                'reply'       => null,
                'days'        => 0,
                'hours'       => 5,
            ],
            [
                'sender_name' => 'Nadia Sfar',
                'email'       => 'nsfar@moe.tn',
                'phone'       => '+216 71 890 123',
                'subject'     => 'Proposition de partenariat institutionnel',
                'message'     => 'Bonjour, je représente un établissement scolaire régional de Sfax. Nous souhaitons intégrer le Frizzly Kit dans notre programme de formation continue d\'enseignants pour l\'année scolaire prochaine. Seriez-vous intéressés par un partenariat institutionnel ? Cordialement.',
                'status'      => 'unread',
                'reply'       => null,
                'days'        => 1,
                'hours'       => 0,
            ],
            [
                'sender_name' => 'Sami Gharbi',
                'email'       => 'sami@gmail.com',
                'phone'       => '+216 55 456 789',
                'subject'     => 'Problème de commande #047',
                'message'     => 'Bonjour, j\'ai passé commande il y a 5 jours (référence #047) mais je n\'ai pas encore reçu de confirmation par email. Pourriez-vous vérifier l\'état de ma commande ? Merci.',
                'status'      => 'read',
                'reply'       => 'Bonjour Sami, votre commande #047 a bien été enregistrée et sera expédiée dans les 48h. Vous recevrez un email de confirmation avec le numéro de suivi. Merci pour votre patience !',
                'days'        => 2,
                'hours'       => 0,
            ],
            [
                'sender_name' => 'Leila Jouini',
                'email'       => 'leila@gmail.com',
                'phone'       => '+216 22 567 890',
                'subject'     => 'Retour d\'expérience très positif',
                'message'     => 'Bonjour, j\'utilise le Frizzly Kit depuis deux mois maintenant. Je voulais vous faire part de mon retour très positif. Mes élèves de CE2 sont beaucoup plus engagés et autonomes depuis que j\'utilise les cartes Socita. Je recommanderai certainement votre produit à mes collègues enseignants.',
                'status'      => 'read',
                'reply'       => null,
                'days'        => 3,
                'hours'       => 0,
            ],
            [
                'sender_name' => 'Hassan Boubaker',
                'email'       => 'h.boubaker@edu.tn',
                'phone'       => '+216 71 678 901',
                'subject'     => 'Formation à distance — disponibilité ?',
                'message'     => 'Bonjour Maram, j\'ai suivi l\'un de vos webinaires en ligne et je suis très intéressé par le programme de formation certifiante. Est-ce que les sessions sont disponibles entièrement à distance ou y a-t-il des séances obligatoires en présentiel à Tunis ?',
                'status'      => 'read',
                'reply'       => null,
                'days'        => 5,
                'hours'       => 0,
            ],
            [
                'sender_name' => 'Mohamed Ferjani',
                'email'       => 'm.ferjani@edu.tn',
                'phone'       => '+216 71 234 123',
                'subject'     => 'Demande de devis pour groupe d\'enseignants',
                'message'     => 'Bonjour, notre association d\'enseignants souhaite acquérir 15 kits Frizzly pour un groupe de formation. Pourriez-vous nous envoyer un devis avec les tarifs préférentiels pour les commandes groupées ? Nous sommes basés à Sousse.',
                'status'      => 'read',
                'reply'       => 'Bonjour Mohamed, merci pour votre intérêt ! Pour une commande de 15 kits, nous proposons une remise de 20%. Je vous envoie le devis détaillé par email dans les prochaines heures.',
                'days'        => 7,
                'hours'       => 0,
            ],
            [
                'sender_name' => 'Mariem Zouari',
                'email'       => 'mariem@edu.tn',
                'phone'       => '+216 71 890 456',
                'subject'     => 'Question sur les cartes Socita',
                'message'     => 'Bonjour, j\'ai acheté le Kit Essentiel la semaine dernière. Pourriez-vous m\'expliquer comment utiliser les cartes Socita pour des élèves de CM2 ? Je cherche des activités adaptées à ce niveau.',
                'status'      => 'unread',
                'reply'       => null,
                'days'        => 8,
                'hours'       => 0,
            ],
        ];

        foreach ($messages as $m) {
            Message::create([
                'sender_name' => $m['sender_name'],
                'email'       => $m['email'],
                'phone'       => $m['phone'],
                'subject'     => $m['subject'],
                'message'     => $m['message'],
                'status'      => $m['status'],
                'reply'       => $m['reply'],
                'replied_at'  => $m['reply'] ? now()->subDays($m['days']) : null,
                'created_at'  => now()->subDays($m['days'])->subHours($m['hours']),
                'updated_at'  => now()->subDays($m['days'])->subHours($m['hours']),
            ]);
        }
    }
}
