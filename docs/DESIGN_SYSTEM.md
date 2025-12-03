# Design System - Club Informatique U-Auben

> Document de référence pour maintenir la cohérence visuelle à travers toutes les pages du projet.

---

## 1. Palette de couleurs

### Couleurs principales

| Nom                    | Variable CSS                  | Valeur HEX | Usage                                              |
| ---------------------- | ----------------------------- | ---------- | -------------------------------------------------- |
| **Rouge accent**       | `--color-accent-red`          | `#e00514`  | CTAs principaux, éléments d'action, mise en valeur |
| **Rouge accent hover** | `--color-accent-red-hover`    | `#b00410`  | État hover des éléments rouges                     |
| **Bleu foncé**         | `--color-secondary-dark-blue` | `#2d256d`  | Footer, éléments secondaires, gradients            |
| **Bleu clair**         | `--color-tertiary-light-blue` | `#009fe3`  | Liens, accents informatifs, focus states           |
| **Blanc**              | `--color-primary-white`       | `#fefefe`  | Arrière-plans, texte sur foncé                     |
| **Gris foncé**         | `--color-neutral-dark-gray`   | `#242423`  | Texte principal                                    |

### Couleurs sémantiques

| État    | Variable          | Valeur    | Usage                         |
| ------- | ----------------- | --------- | ----------------------------- |
| Succès  | `--color-success` | `#22c55e` | Validations, confirmations    |
| Warning | `--color-warning` | `#f59e0b` | Alertes, limites approchées   |
| Erreur  | `--color-error`   | `#ef4444` | Erreurs de validation, échecs |
| Info    | `--color-info`    | `#009fe3` | Messages informatifs          |

### Gradients signatures

```css
/* Gradient principal (rouge → bleu foncé) */
background: linear-gradient(
    135deg,
    var(--color-accent-red) 0%,
    var(--color-secondary-dark-blue) 100%
);

/* Gradient footer */
background: linear-gradient(
    135deg,
    var(--color-secondary-dark-blue) 0%,
    #1a1547 100%
);

/* Gradient accent ligne */
background: linear-gradient(
    90deg,
    var(--color-tertiary-light-blue) 0%,
    var(--color-accent-red) 50%,
    var(--color-tertiary-light-blue) 100%
);
```

---

## 2. Typographie

### Police principale

-   **Famille** : Inter (via fonts.bunny.net)
-   **Fallback** : "Segoe UI", sans-serif

### Échelle typographique

| Élément | Variable            | Taille          | Poids   | Usage                 |
| ------- | ------------------- | --------------- | ------- | --------------------- |
| H1      | `--font-size-h1`    | 2.5rem (40px)   | 800     | Titres de page        |
| H2      | `--font-size-h2`    | 2rem (32px)     | 700     | Titres de section     |
| H3      | `--font-size-h3`    | 1.5rem (24px)   | 700     | Sous-sections, cartes |
| Body    | `--font-size-body`  | 1rem (16px)     | 400     | Texte courant         |
| Small   | `--font-size-small` | 0.875rem (14px) | 400-500 | Labels, légendes      |

### Poids disponibles

| Variable                 | Valeur | Usage            |
| ------------------------ | ------ | ---------------- |
| `--font-weight-regular`  | 400    | Texte courant    |
| `--font-weight-medium`   | 500    | Labels, liens    |
| `--font-weight-semibold` | 600    | Boutons, emphase |
| `--font-weight-bold`     | 700    | Titres           |

---

## 3. Espacements

Système basé sur des multiples de 8px.

| Variable        | Valeur | Usage                                 |
| --------------- | ------ | ------------------------------------- |
| `--spacing-xs`  | 8px    | Gaps minimaux, marges internes icônes |
| `--spacing-sm`  | 16px   | Gaps standards, padding boutons       |
| `--spacing-md`  | 24px   | Marges entre éléments                 |
| `--spacing-lg`  | 32px   | Sections internes                     |
| `--spacing-xl`  | 48px   | Séparation de sections majeures       |
| `--spacing-2xl` | 64px   | Padding conteneurs principaux         |
| `--spacing-3xl` | 96px   | Grands espaces visuels                |

---

## 4. Rayons de bordure

| Variable        | Valeur | Usage                           |
| --------------- | ------ | ------------------------------- |
| `--radius-sm`   | 4px    | Badges, tags                    |
| `--radius-md`   | 8px    | Boutons, inputs, cartes légères |
| `--radius-lg`   | 12px   | Cartes principales, modales     |
| `--radius-full` | 9999px | Avatars, badges pill, cercles   |

---

## 5. Ombres

| Variable      | Valeur                             | Usage                      |
| ------------- | ---------------------------------- | -------------------------- |
| `--shadow-sm` | `0 1px 2px rgba(0,0,0,0.05)`       | Éléments subtils           |
| `--shadow-md` | `0 4px 6px -1px rgba(0,0,0,0.1)`   | Cartes, dropdowns          |
| `--shadow-lg` | `0 10px 15px -3px rgba(0,0,0,0.1)` | Modales, popovers          |
| `--shadow-xl` | `0 20px 25px -5px rgba(0,0,0,0.1)` | Éléments flottants majeurs |

---

## 6. Composants UI

### 6.1 Boutons

#### Variantes

| Classe            | Style                           | Usage                |
| ----------------- | ------------------------------- | -------------------- |
| `.btn--primary`   | Fond rouge, texte blanc         | Action principale    |
| `.btn--secondary` | Fond bleu foncé, texte blanc    | Action secondaire    |
| `.btn--tertiary`  | Fond bleu clair, texte blanc    | Actions alternatives |
| `.btn--outline`   | Bordure rouge, fond transparent | Actions tertiaires   |
| `.btn--ghost`     | Transparent, texte gris         | Annuler, retour      |

#### Tailles

| Classe     | Padding   | Usage           |
| ---------- | --------- | --------------- |
| `.btn--sm` | 8px 16px  | Actions inline  |
| (default)  | 12px 24px | Standard        |
| `.btn--lg` | 16px 32px | CTAs importants |

#### Comportements

-   Hover : légère élévation (`translateY(-2px)`) + ombre
-   Disabled : `opacity: 0.5`, `cursor: not-allowed`
-   Loading : spinner + texte "En cours..."

### 6.2 Formulaires

#### Labels

```html
<label class="form-group__label form-group__label--required">
    <i class="fa-solid fa-icon form-group__label-icon"></i>
    Nom du champ
</label>
```

-   Icône FontAwesome en bleu clair (`--color-tertiary-light-blue`)
-   Astérisque rouge pour les champs requis

#### Inputs

```css
.form-group__input {
    padding: 14px 18px;
    background: var(--color-bg-secondary);
    border: 2px solid transparent;
    border-radius: var(--radius-md);
}
```

-   **Hover** : fond blanc, bordure grise
-   **Focus** : bordure bleu clair + halo `box-shadow: 0 0 0 4px rgba(0, 159, 227, 0.1)`
-   **Erreur** : bordure rouge + message avec icône

#### Zone d'upload

-   Style drag & drop avec bordure dashed
-   Icône `fa-cloud-arrow-up` en bleu clair
-   État dragging : scale + changement de fond

### 6.3 Cartes

```css
.card,
.candidate-register__card {
    background: var(--color-bg-primary);
    border-radius: var(--radius-lg);
    padding: var(--spacing-xl) à var(--spacing-2xl);
    box-shadow: multi-layer subtle shadow;
    border: 1px solid rgba(0, 0, 0, 0.03);
}
```

### 6.4 Alertes

| Variante          | Couleur bordure | Fond       | Usage         |
| ----------------- | --------------- | ---------- | ------------- |
| `.alert--success` | Vert            | Vert 10%   | Confirmation  |
| `.alert--error`   | Rouge           | Rouge 10%  | Erreur        |
| `.alert--warning` | Orange          | Orange 10% | Avertissement |
| `.alert--info`    | Bleu clair      | Bleu 10%   | Information   |

Structure : icône FA + message, bordure gauche 4px.

### 6.5 Badges

Pill shape (`border-radius: full`), fond coloré 10%, texte coloré 100%.

---

## 7. Iconographie

### Bibliothèque

**FontAwesome 6** (Kit chargé via CDN)

### Icônes courantes

| Contexte    | Icône                                          |
| ----------- | ---------------------------------------------- |
| Utilisateur | `fa-user`, `fa-user-pen`                       |
| Email       | `fa-envelope`                                  |
| Matricule   | `fa-graduation-cap`                            |
| Vision      | `fa-eye`                                       |
| Motivation  | `fa-lightbulb`                                 |
| Validation  | `fa-circle-check`                              |
| Erreur      | `fa-circle-exclamation`, `fa-circle-xmark`     |
| Info        | `fa-circle-info`                               |
| Upload      | `fa-cloud-arrow-up`                            |
| PDF         | `fa-file-pdf`                                  |
| Image       | `fa-image`                                     |
| Navigation  | `fa-arrow-left`, `fa-arrow-right`              |
| Sécurité    | `fa-lock`                                      |
| Loading     | `fa-spinner fa-spin`                           |
| Social      | `fa-facebook-f`, `fa-linkedin-in`, `fa-github` |

---

## 8. Layout

### Header

-   Fond blanc, sticky top
-   Logo avec carré gradient (rouge → bleu foncé)
-   Navigation avec liens hover rouge
-   CTA "Devenir Candidat" en bouton rouge

### Footer

-   **Fond** : gradient bleu foncé (`#2d256d` → `#1a1547`)
-   **Accent** : ligne dégradée en haut (bleu clair → rouge → bleu clair)
-   **Titres** : barre verticale bleu clair avant le texte
-   **Liens** : hover bleu clair avec underline animé
-   **Icônes sociales** : cercles avec bordure bleu clair, hover plein
-   **Made with** : cœur rouge animé (pulse)

### Structure de page type

```
┌─────────────────────────────────────┐
│ HEADER (sticky, blanc)              │
├─────────────────────────────────────┤
│                                     │
│ MAIN CONTENT                        │
│ - Background subtil (gradient gris) │
│ - Cercles décoratifs flottants      │
│ - Container max-width: 800px        │
│ - Card principale blanche           │
│                                     │
├─────────────────────────────────────┤
│ FOOTER (gradient bleu foncé)        │
└─────────────────────────────────────┘
```

---

## 9. Animations & Transitions

### Variables de timing

| Variable              | Durée | Usage                          |
| --------------------- | ----- | ------------------------------ |
| `--transition-fast`   | 150ms | Hovers, focus                  |
| `--transition-normal` | 300ms | Ouvertures, changements d'état |
| `--transition-slow`   | 500ms | Animations complexes           |

### Animations clés

```css
/* Entrée depuis le haut */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Entrée depuis le bas */
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Pulsation subtile (badges, cœur) */
@keyframes pulse-soft {
    0%,
    100% {
        box-shadow: 0 0 0 0 rgba(224, 5, 20, 0.1);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(224, 5, 20, 0);
    }
}

/* Cercles flottants */
@keyframes float {
    0%,
    100% {
        transform: translate(0, 0);
    }
    50% {
        transform: translate(-10px, 20px);
    }
}

/* Spinner */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
```

---

## 10. Responsive Design

### Breakpoints

| Nom          | Largeur | Usage                 |
| ------------ | ------- | --------------------- |
| Desktop wide | ≥1440px | Layouts étendus       |
| Desktop      | ≥1024px | Layout standard       |
| Tablet       | ≥768px  | Adaptation 2 colonnes |
| Mobile       | ≥576px  | Mobile standard       |
| Small mobile | <400px  | Petits écrans         |

### Règles responsive

1. **Grilles** : passer de multi-colonnes à 1 colonne sous 768px
2. **Padding cartes** : réduire progressivement (2xl → xl → lg → md)
3. **Typographie** : utiliser `clamp()` pour les titres
4. **Navigation** : menu burger sous 768px
5. **Boutons** : full-width sur mobile
6. **Décors** : réduire opacité/taille des cercles sur mobile

---

## 11. Patterns de design

### Hiérarchie visuelle

1. **Titre principal** : grand, gradient texte rouge→bleu
2. **Badge contextuel** : pill animé au-dessus du titre
3. **Sous-titre** : texte secondaire avec emphase sur une partie
4. **Progress indicator** : étapes visuelles avec icônes
5. **Sections** : header avec icône + titre + sous-titre

### Feedback utilisateur

-   **Compteur de caractères** : barre de progression + compteur numérique
-   **États de warning** : changement de couleur progressif (bleu → orange → rouge)
-   **Loading** : spinner FA ou animation de cercles
-   **Overlay** : fond semi-transparent + blur + carte centrée

### Accessibilité

-   Labels associés aux inputs
-   Couleurs avec contraste suffisant
-   Focus visible sur tous les éléments interactifs
-   Icônes accompagnées de texte (pas seules)

---

## 12. Checklist pour nouvelles pages

Avant de créer une nouvelle page, vérifier :

-   [ ] Import des CSS globaux (global.css, components.css, layout.css)
-   [ ] Utilisation des variables CSS existantes
-   [ ] Header et footer cohérents (layout app.blade.php)
-   [ ] Icônes FontAwesome (pas de SVG inline)
-   [ ] Boutons avec les classes BEM existantes
-   [ ] Formulaires avec la structure `.form-group--modern`
-   [ ] Alertes avec les variantes `.alert--*`
-   [ ] Responsive testé sur 4 breakpoints (1024, 768, 576, 400)
-   [ ] Animations d'entrée pour les éléments principaux
-   [ ] États de chargement pour les actions async

---

_Document généré le 3 décembre 2025 - Version 1.0_
