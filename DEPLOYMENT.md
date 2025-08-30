# Laravel Water Website - Vercel Deployment Guide

## Prerequisites

1. A Vercel account
2. A MySQL database (you can use PlanetScale, Railway, or any other MySQL provider)
3. Your Laravel application code

## Deployment Steps

### 1. Database Setup

First, set up your MySQL database and import the `laravel.sql` file:

```bash
# Import the database structure and data
mysql -u your_username -p your_database_name < laravel.sql
```

### 2. Environment Variables

Update the `vercel.json` file with your actual database credentials:

```json
{
  "env": {
    "DB_CONNECTION": "mysql",
    "DB_HOST": "your-actual-database-host",
    "DB_PORT": "3306",
    "DB_DATABASE": "your-actual-database-name",
    "DB_USERNAME": "your-actual-database-username",
    "DB_PASSWORD": "your-actual-database-password"
  }
}
```

### 3. Deploy to Vercel

1. Push your code to GitHub
2. Connect your repository to Vercel
3. Vercel will automatically detect the Laravel configuration
4. Set the following environment variables in Vercel dashboard:
   - `APP_KEY` (generate with `php artisan key:generate`)
   - `APP_URL` (your Vercel domain)
   - Database credentials

### 4. Build Configuration

The project is configured with:
- `buildCommand`: Installs PHP dependencies, Node.js dependencies, and builds assets
- `outputDirectory`: Set to `public` (Laravel's public directory)
- Routes configured to handle Laravel routing

### 5. Post-Deployment

After deployment, you may need to:
1. Run database migrations: `php artisan migrate`
2. Clear caches: `php artisan config:clear && php artisan cache:clear`
3. Set up storage links: `php artisan storage:link`

## Troubleshooting

### Common Issues

1. **"No Output Directory named 'dist' found"**
   - Solution: The `vercel.json` file is now configured to use `public` as the output directory

2. **Database Connection Issues**
   - Ensure your database credentials are correct in the environment variables
   - Make sure your database is accessible from Vercel's servers

3. **Asset Loading Issues**
   - The build process now properly builds assets to `public/build`
   - Routes are configured to serve assets from the correct location

### Environment Variables Checklist

Make sure these are set in Vercel:
- `APP_KEY`
- `APP_URL`
- `DB_HOST`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `APP_ENV=production`
- `APP_DEBUG=false`

## File Structure

The deployment uses these key files:
- `vercel.json` - Vercel configuration
- `vite.config.js` - Asset building configuration
- `package.json` - Node.js dependencies and scripts
- `composer.json` - PHP dependencies
- `.vercelignore` - Files to exclude from deployment 