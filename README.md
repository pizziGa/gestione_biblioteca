# 📚 Biblioteca WebApp

Una moderna applicazione web per la gestione di una biblioteca. Gli **amministratori** possono aggiungere e gestire libri e copie fisiche, mentre i **clienti** possono consultare il catalogo e prenotare i libri disponibili.

## 🛠️ Stack Tecnologico

- **Laravel 12** – Backend
- **Vue 3 + Inertia.js** – Frontend reactive con esperienza SPA
- **MySQL** – Database relazionale (eseguito in Docker)

## ⚙️ Funzionalità

### 👩‍💼 Amministratori
- Creazione, modifica e rimozione dei libri
- Gestione delle copie fisiche associate ai libri
- Visualizzazione e gestione delle prenotazioni

### 👤 Clienti
- Consultazione del catalogo libri
- Prenotazione di copie fisiche disponibili
- Storico delle prenotazioni effettuate

## 🚀 Installazione e Avvio

```bash
# Clona il repository
git clone https://github.com/pizziGa/gestione_biblioteca.git
cd gestione_biblioteca

# Installa le dipendenze PHP
composer install

# Installa le dipendenze JS
npm install

# Crea il file .env
cp .env.example .env

# Genera il link a storage
php artisan storage:link

# Esegui le migrazioni
php artisan migrate

# Avvia il server di sviluppo
composer run dev

# In un secondo terminale, avvia il compose per MySQL
docker compose up

