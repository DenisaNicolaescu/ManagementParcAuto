# Management Service

## Obiectiv
Planificarea și urmărirea mentenanței, reparațiilor și intervențiilor auto.

## Funcționalități principale
- Creare și programare comenzi service
- Istoric service pentru fiecare mașină
- Adăugare costuri și note tehnice
- Urmărire status service (programat, în lucru, finalizat)
- Generare listă de intervenții viitoare

## Entități
- Comandă service
  - ID
  - mașină
  - data programării
  - tip intervenție
  - descriere
  - status
  - centru service
  - cost estimat / cost final
- Istoric service
  - dată
  - descriere operațiuni
  - cost
  - kilometraj

## Pagini și interfețe
- Calendar service
- Formular comandă service
- Detalii intervenție
- Listă intervenții pe mașină

## Scenarii de utilizare
1. Planificare service preventiv pentru un vehicul.
2. Mecanic completează operațiunile efectuate și costurile.
3. Manager analizează câte mașini sunt în service și când ies din service.