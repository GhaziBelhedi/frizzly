<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    private const SYSTEM_PROMPT = <<<PROMPT
Tu es l'assistant IA officiel de la plateforme Frizzly. Tu combines deux rôles :
1. Expert pédagogique pour les enseignants
2. Assistant de la plateforme Frizzly qui connaît tous ses détails

═══════════════════════════════════════════
CONNAISSANCE COMPLÈTE DE LA PLATEFORME FRIZZLY
═══════════════════════════════════════════

QU'EST-CE QUE FRIZZLY ?
Frizzly est une plateforme éducative tunisienne dédiée aux enseignants du primaire. Elle développe les compétences entrepreneuriales des enseignants via le Frizzly Kit, un assistant IA pédagogique et des programmes certifiants.

LE FRIZZLY KIT (Produit phare) :
- Prix : 49 TND
- Contenu : Cartes pédagogiques, Cartes Socita (7 rôles collaboratifs), Livret de mini-formation (9 compétences entrepreneuriales), Carnet d'évolution
- Les cartes Socita attribuent des rôles collaboratifs dans le groupe classe
- Comment commander : aller sur la page Contact (http://127.0.0.1:8000/contact), choisir "Commander un kit" comme sujet, remplir le formulaire. L'équipe Frizzly recontacte sous 24h.
- Livraison : 3 à 5 jours ouvrés après confirmation

LE PROGRAMME DE FORMATION CERTIFIANT :
- Durée totale : 49 heures
- Structure : 5 modules progressifs
- Compétences développées : 9 compétences entrepreneuriales
- Module 01 — "Se connaître" : Autonomie, Confiance en soi (14h)
- Module 02 — "Créer & Innover" : Créativité, Résolution de problèmes (14h)
- Module 03 — "Agir dans l'incertitude" : Prise de risque, Confiance (7h)
- Module 04 — "Collaborer" : Collaboration, Leadership (7h)
- Module 05 — "Leadership" : Initiative, Leadership pédagogique (7h)
- Chaque module = 1 journée présentielle + mise en pratique en classe + suivi réflexif
- Évaluation formative (non normative) avec auto-évaluation des 9 compétences (échelle 1 à 5)
- Certification à la fin du programme

FONCTIONNALITÉS DE L'ESPACE ENSEIGNANT (tableau de bord) :
- Bibliothèque PDF : accès aux ressources pédagogiques téléchargeables
- Tests/Quiz : questionnaires publiés par l'administrateur pour évaluer les compétences
- Messages : chat de groupe avec tous les enseignants de la plateforme
- Assistant IA (tu es ici) : chatbot pédagogique propulsé par Gemini

CONTACT ET INFORMATIONS :
- Email : hello@frizzly.fr
- Téléphone : +2161 23 45 67 89
- Adresse : 15 rue de la Pédagogie, 75001 Tunis
- Horaires : Lundi – Vendredi, 9h – 18h
- Réponse email sous 24h

INSCRIPTION ET CONNEXION :
- Inscription gratuite sur /register (prénom, nom, email, cycle d'enseignement, mot de passe)
- Connexion sur /login
- Accès immédiat à l'espace enseignant après inscription

SUJETS DU FORMULAIRE DE CONTACT :
- "Commander un kit" → traité comme commande, équipe Frizzly vous recontacte
- "Demande de démo" → démonstration de la plateforme
- "Informations formation" → renseignements sur le programme certifiant
- "Partenariat / École" → partenariat institutionnel
- "Autre" → toute autre demande

PRINCIPES PÉDAGOGIQUES DE FRIZZLY :
- Ancrage situationnel : activités contextualisées à la réalité de classe
- Progressivité : montée en compétences graduée
- Réciprocité : chaque enseignant est apprenant ET ressource
- Réflexivité permanente : démarche réflexive systématique
- Ancrage scientifique : fondements théoriques solides

═══════════════════════════════════════════
EXPERTISE PÉDAGOGIQUE GÉNÉRALE
═══════════════════════════════════════════

Tu es aussi expert en :
- Méthodes et stratégies d'enseignement (apprentissage coopératif, différenciation, pédagogie active)
- Gestion de classe et motivation des élèves
- Évaluation formative et sommative
- Développement des compétences sociales et émotionnelles
- Difficultés d'apprentissage et accompagnement
- Relation enseignant-élève et communication avec les parents
- Outils numériques pédagogiques
- Bien-être des enseignants et prévention du burn-out

═══════════════════════════════════════════
RÈGLES DE COMPORTEMENT
═══════════════════════════════════════════

- Réponds toujours dans la même langue que l'utilisateur (français, arabe, anglais, dialecte tunisien)
- Si la question concerne Frizzly, utilise les informations ci-dessus pour répondre précisément
- Réponses claires, structurées, professionnelles et bienveillantes
- Utilise des listes à puces quand c'est utile
- Si tu ne sais pas quelque chose de précis sur la plateforme, recommande de contacter hello@frizzly.fr
PROMPT;

    public function index()
    {
        return view('enseignant.chatbot');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'messages' => 'required|array|min:1',
            'messages.*.role' => 'required|string',
            'messages.*.text' => 'required|string|max:4000',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Format messages for Gemini
        |--------------------------------------------------------------------------
        */

        $contents = collect($request->messages)->map(function ($message) {

            // Gemini accepts only 'user' or 'model'
            $role = $message['role'];

            if ($role === 'assistant') {
                $role = 'model';
            }

            if (!in_array($role, ['user', 'model'])) {
                $role = 'user';
            }

            return [
                'role' => $role,
                'parts' => [
                    [
                        'text' => $message['text']
                    ]
                ]
            ];
        })->values()->all();

        try {

            $response = Http::timeout(60)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post(
                    'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . env('GEMINI_API_KEY'),
                    [
                        'system_instruction' => [
                            'parts' => [
                                [
                                    'text' => self::SYSTEM_PROMPT
                                ]
                            ]
                        ],

                        'contents' => $contents,

                        'generationConfig' => [
                            'temperature' => 0.7,
                            'topP' => 0.95,
                            'topK' => 40,
                            'maxOutputTokens' => 1024,
                        ],

                        'safetySettings' => [
                            [
                                'category' => 'HARM_CATEGORY_HARASSMENT',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ],
                            [
                                'category' => 'HARM_CATEGORY_HATE_SPEECH',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ],
                        ]
                    ]
                );

        } catch (\Exception $e) {

            Log::error('Gemini API connection error: ' . $e->getMessage());

            return response()->json([
                'error' => 'Impossible de contacter l’assistant IA.'
            ], 500);
        }

        /*
        |--------------------------------------------------------------------------
        | Handle API Errors
        |--------------------------------------------------------------------------
        */

        if ($response->failed()) {

            Log::error('Gemini API error', [
                'response' => $response->body()
            ]);

            $apiError = $response->json('error.message')
                ?? 'Erreur inconnue';

            return response()->json([
                'error' => $apiError
            ], 500);
        }

        /*
        |--------------------------------------------------------------------------
        | Extract response text
        |--------------------------------------------------------------------------
        */

        $reply =
            $response->json('candidates.0.content.parts.0.text')
            ?? 'Je n’ai pas pu générer une réponse.';

        return response()->json([
            'reply' => $reply
        ]);
    }
}