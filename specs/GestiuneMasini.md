# Gestiune Mașini

## Obiectiv
Gestionarea flotei de vehicule: date tehnice, istoric, status și planificare.

## Funcționalități principale
- Adăugare, editare, ștergere mașini
- Vizualizare listă cu stare, kilometraj, combustibil, atribuire
- Căutare și filtrare după marcă, model, număr înmatriculare, status
- Istoric service, asigurări, viniete, anvelope
- Import / export fișiere CSV pentru flota de mașini

## Entități
- Mașină
  - ID
  - marcă
  - model
  - an
  - număr înmatriculare
  - tip combustibil
  - kilometraj
  - status (activă, în service, rezervă)
  - data ultimei revizii
  - șofer atribuit
  - note
- Model tehnic
  - capacitate
  - putere
  - consum estimat

## Pagini și interfețe
- Dashboard mașini
- Formular detalii mașină
- Listă și tabel mașini
- Fișă istoric service / anvelope / asigurări

## Relații
- Mașină poate avea mai multe înregistrări de service
- Mașină poate avea asociată o asigurare și o vinietă curentă
- Mașină poate avea o listă de anvelope montate / schimbate

## Scenarii de utilizare
1. Operator adaugă o nouă mașină în flotă.
2. Manager caută mașina după număr de înmatriculare și verifică statusul.
3. Tehnician actualizează kilometrajul și programul de service.