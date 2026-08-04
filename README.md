# University Portal

Three parts, three zips:

1. **backend-laravel/** — Laravel 11 + Sanctum + MySQL API (Dockerized)
2. **frontend-nextjs/** — Next.js + React + Tailwind (student/lecturer portal, deploys to Vercel)
3. **admin-angular/** — Angular + Bootstrap (admin panel, deploys to Vercel as a second project, or anywhere static)

Features included: auth (register/login/logout via Sanctum tokens, role-based: student/lecturer/admin),
departments, courses, enrollments, grades with auto letter-grade + GPA point, timetable, announcements,
fees/payment status, admin dashboard stats.

---

## 1. Run the backend locally (Termux or any machine with Docker)

You need Docker installed. On Termux, install `docker` via a proot-distro (Ubuntu) since Termux itself
can't run Docker natively — or simpler: install PHP + Composer + MySQL directly in Termux and skip Docker
for local dev (Docker is only required for the Render deployment).

**Option A — Docker (recommended, matches production):**
```bash
cd university-portal
cp backend-laravel/.env.example backend-laravel/.env
docker compose up --build
```
This starts MySQL on port 3306 and the Laravel API on port 8000.
First run only — seed demo data:
```bash
docker compose exec backend php artisan db:seed
```
API is now live at `http://localhost:8000/api`.

**Option B — Native PHP (no Docker, if Termux Docker is too heavy):**
```bash
cd backend-laravel
cp .env.example .env
composer install
php artisan key:generate
# point DB_HOST in .env to 127.0.0.1 and run a local MySQL server
php artisan migrate --seed
php artisan serve
```

Demo admin login after seeding: `admin@university.edu` / `password123`

---

## 2. Run the Next.js frontend locally

```bash
cd frontend-nextjs
cp .env.local.example .env.local
npm install
npm run dev
```
Visit `http://localhost:3000`. It talks to the API at the URL set in `.env.local`
(`NEXT_PUBLIC_API_URL=http://localhost:8000/api` by default).

---

## 3. Run the Angular admin panel locally

```bash
cd admin-angular
npm install
npm start
```
Visit `http://localhost:4200`. It uses `src/environments/environment.ts` for the API URL
(`http://localhost:8000/api` by default).

---

## 4. Deploying

**Backend → Render (Docker):**
1. Push `backend-laravel/` to its own GitHub repo (or use the `render.yaml` blueprint at the project root).
2. In Render: New → Web Service → connect the repo → Environment: Docker.
3. Add environment variables (mirror your `.env`): `APP_KEY` (leave blank, entrypoint generates it on first
   boot — but for production it's better to generate one with `php artisan key:generate --show` and set it),
   `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `FRONTEND_URL`, `SANCTUM_STATEFUL_DOMAINS`.
4. Add a managed MySQL database (Render's own MySQL, or an external one like PlanetScale/Railway) and point
   the `DB_*` vars at it.
5. Deploy. Render builds the Dockerfile, runs migrations automatically via `docker/entrypoint.sh`.

**Next.js frontend → Vercel:**
1. Push `frontend-nextjs/` to its own GitHub repo.
2. In Vercel: New Project → import repo → framework auto-detected as Next.js.
3. Set env var `NEXT_PUBLIC_API_URL` to your live Render backend URL, e.g.
   `https://university-portal-api.onrender.com/api`.
4. Deploy.

**Angular admin → Vercel (as a static build) or Netlify:**
1. Before deploying, update `src/environments/environment.prod.ts` with your real Render backend URL.
2. Push `admin-angular/` to its own repo.
3. Vercel: New Project → framework preset "Other" → Build Command `npm run build -- --configuration=production`
   → Output Directory `dist/admin`.
4. Deploy.

**Final step:** once the frontend URLs are live, update `FRONTEND_URL` and `SANCTUM_STATEFUL_DOMAINS` on the
Render backend to match your real Vercel domains (comma-separate if you have two), then redeploy the backend.
