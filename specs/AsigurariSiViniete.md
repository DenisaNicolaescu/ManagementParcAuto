# Asigurări și Viniete

## Obiectiv
Administrarea polițelor de asigurare și a vinietelor pentru flota de mașini.

## Funcționalități principale
- Înregistrare polițe asigurare RCA / CASCO
- Urmărire data expirării și avertizări
- Înregistrare viniete naționale / internaționale
- Asociere asigurări și viniete la mașini
- Vizualizare status valabilitate

## Entități
- Asigurare
  - ID
  - tip asigurare
  - societate
  - data emiterii
  - data expirării
  - poliță / număr contract
  - mașină asociată
  - cost
- Vinietă
  - ID
  - tip vinietă
  - valabilitate
  - țară / zonă
  - număr
  - mașină asociată

## Pagini și interfețe
- Listă asigurări
- Listă viniete
- Dashboard expirări
- Formular asociere la vehicul

## Scenarii de utilizare
1. Administrator salvează o nouă poliță RCA.
2. Sistemul avertizează la 30 de zile înainte de expirare.
3. Operator verifică vinieta pentru o mașină înainte de plecare.