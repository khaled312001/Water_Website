# Laravel Water Website - Deployment Guide

## ⚠️ Important Note About Vercel

**Vercel is primarily designed for frontend applications and has limited PHP support.** Deploying a full Laravel application on Vercel is challenging and not recommended for production use.

## Current Vercel Configuration

The project is now configured with:
- `api/index.php` - Laravel bootstrap for serverless functions
- `api/test.php` - Simple test endpoint
- Proper routing configuration
- Error handling for debugging

## Testing the Deployment

After deployment, you can test:
1. **Basic PHP**: Visit `/test` to see if PHP is working
2. **Laravel**: Visit the root URL to test Laravel bootstrap

## Recommended Deployment Platforms

### 1. **Railway** (Recommended)
- Excellent Laravel support
- Easy database integration
- Automatic deployments from GitHub
- Free tier available

### 2. **Heroku**
- Great Laravel support
- Easy to deploy
- Good documentation
- Paid service

### 3. **DigitalOcean App Platform**
- Good Laravel support
- Scalable
- Reasonable pricing

### 4. **AWS Elastic Beanstalk**
- Enterprise-grade
- Highly scalable
- More complex setup

## Alternative: Vercel for Frontend Only

If you want to use Vercel, consider this approach:

1. **Backend**: Deploy Laravel API on Railway/Heroku
2. **Frontend**: Deploy static assets on Vercel
3. **Database**: Use external MySQL service

## Quick Railway Deployment

### 1. Create Railway Account
- Go to [railway.app](https://railway.app)
- Sign up with GitHub

### 2. Deploy Your App
```bash
# Install Railway CLI
npm install -g @railway/cli

# Login to Railway
railway login

# Initialize project
railway init

# Deploy
railway up
```

### 3. Set Environment Variables
In Railway dashboard, set:
- `APP_KEY` (generate with `php artisan key:generate`)
- `APP_URL` (your Railway domain)
- Database credentials
- `APP_ENV=production`
- `APP_DEBUG=false`

### 4. Database Setup
- Create MySQL database in Railway
- Import your `laravel.sql` file
- Update database credentials in environment variables

## Database Import

```bash
# Import the database structure and data
mysql -u your_username -p your_database_name < laravel.sql
```

## Environment Variables Checklist

Make sure these are set in your deployment platform:
- `APP_KEY`
- `APP_URL`
- `DB_HOST`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `APP_ENV=production`
- `APP_DEBUG=false`

## Post-Deployment Steps

After deployment:
1. Run database migrations: `php artisan migrate`
2. Clear caches: `php artisan config:clear && php artisan cache:clear`
3. Set up storage links: `php artisan storage:link`

## Troubleshooting

### Common Issues

1. **"The pattern doesn't match any Serverless Functions"**
   - Solution: The `api/index.php` file is now created and configured

2. **"Vendor directory not found"**
   - Solution: Ensure `composer install` runs during build
   - Check that `vendor` directory is not in `.vercelignore`

3. **Database Connection Issues**
   - Ensure your database credentials are correct
   - Make sure your database is accessible from your deployment platform

4. **Asset Loading Issues**
   - The build process builds assets to `public/build`
   - Ensure your web server is configured to serve static files

5. **Permission Issues**
   - Make sure storage and bootstrap/cache directories are writable
   - Set proper file permissions

### Vercel-Specific Issues

1. **PHP Runtime Not Found**
   - Vercel's PHP support is experimental
   - Consider using Railway or Heroku instead

2. **Laravel Bootstrap Fails**
   - Check the `/test` endpoint first to verify PHP works
   - Review error messages in the Laravel bootstrap

## File Structure

The deployment uses these key files:
- `vercel.json` - Vercel configuration
- `api/index.php` - Laravel serverless function
- `api/test.php` - PHP test endpoint
- `vite.config.js` - Asset building configuration
- `package.json` - Node.js dependencies and scripts
- `composer.json` - PHP dependencies
- `.vercelignore` - Files to exclude from deployment
- `laravel.sql` - Database structure and sample data 