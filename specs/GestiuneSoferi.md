# Gestiune Șoferi

## Obiectiv
Administrarea bazei de șoferi, atribuirea mașinilor și gestionarea documentelor.

## Funcționalități principale
- Adăugare, editare, ștergere șofer
- Gestionare date personale și documente
- Atribuire / detașare la vehicule
- Monitorizare permis, perioadă de valabilitate, certificări
- Vizualizare șoferi activi / suspendați / în training

## Entități
- Șofer
  - ID
  - nume
  - CNP
  - data nașterii
  - telefon
  - email
  - permis categoria
  - data expirării permisului
  - stare
  - mașină atribuită
  - note
- Document
  - tip document
  - dată emitere
  - dată expirare
  - status

## Pagini și interfețe
- Listă șoferi
- Profil șofer
- Istoric atribuiri vehicul
- Notificări expirare documente

## Scenarii de utilizare
1. Manager înregistrează un nou șofer.
2. Operator vede ce șoferi au permisul expirat.
3. Manager atribuie un șofer la o nouă mașină pentru o misiune.