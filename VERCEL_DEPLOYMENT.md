# Vercel Deployment for Laravel

## Current Configuration

This project is configured for Vercel deployment using serverless functions:

### Files Structure:
```
api/
├── index.php    # Laravel bootstrap for serverless functions
├── test.php     # Simple PHP test endpoint
└── composer.json # PHP dependencies

vercel.json      # Vercel configuration
.vercelignore    # Files to exclude
```

### Key Changes Made:

1. **Moved build files**: `package.json` and `vite.config.js` are temporarily moved to prevent Vercel from running Node.js build process
2. **Created serverless functions**: PHP functions in the `api/` directory
3. **Simplified configuration**: Focus on PHP serverless functions only

## Testing

After deployment:
- Visit `/test` to verify PHP is working
- Visit root URL to test Laravel bootstrap

## Limitations

⚠️ **Important**: Vercel's PHP support is very limited and may not work well for full Laravel applications due to:
- Limited file system access
- No database connections
- Missing Laravel features

## Restoring Build Files

To restore the build files for local development:

```bash
# Restore package.json
mv package.json.backup package.json

# Restore vite.config.js
mv vite.config.js.backup vite.config.js

# Install dependencies
npm install
```

## Recommended Alternative

For production Laravel applications, use **Railway** instead:
- Excellent Laravel support
- Full PHP environment
- Database integration
- Better performance

## Troubleshooting

If you encounter issues:
1. Check the `/test` endpoint first
2. Review Vercel deployment logs
3. Consider switching to Railway for better Laravel support 