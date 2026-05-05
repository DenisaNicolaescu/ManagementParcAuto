# Anvelope

## Obiectiv
Gestionarea stocului de anvelope și istoricul montajului pentru vehicule.

## Funcționalități principale
- Evidență anvelope disponibile în stoc
- Gestionare montaj / demontaj / roatate
- Legare anvelope / vehicule
- Urmărire kilometraj și sezon
- Notificări pentru schimb anvelope iarnă/vară

## Entități
- Anvelopă
  - ID
  - marcă
  - dimensiune
  - tip
  - sezon
  - stare
  - data achiziției
  - kilometraj utilizare
- Montaj
  - mașină
  - anvelopă
  - dată montaj
  - poziție roată
  - kilometraj la montaj

## Pagini și interfețe
- Stoc anvelope
- Istoric montaj
- Formular montaj/demontaj
- Analiză uzură

## Scenarii de utilizare
1. Operator înregistrează un set de anvelope noi în stoc.
2. Mecanic marchează montajul anvelopelor pe un vehicul.
3. Manager verifică câte anvelope sunt disponibile și care sunt programate la montaj.