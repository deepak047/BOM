# BOM & Inventory System

## Setup

1. Clone and install:
   ```bash
   git clone ...
   composer install
   cp .env.example .env
   php artisan key:generate
   # configure DB in .env
   php artisan migrate --seed
   ```

2. Set up queues:
   - Using Redis:  
     ```bash
     php artisan queue:work redis
     ```
   - Using database:
     ```bash
     php artisan queue:table
     php artisan migrate
     php artisan queue:work
     ```

3. Roles for testing:
   - Admin: login as `admin@example.com | password`
   - Purchase Dept: `purchase@example.com | password`
   - Engineer: `engineer@example.com | password`

4. Sample BOM template is at `/public/assets/sample/BOM_REV_1_test.xlsx`.

5. Access dashboard at `/home`.


