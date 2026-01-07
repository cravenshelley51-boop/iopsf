# Docker Deployment Guide for Render

This guide explains how to deploy the SecureVault Laravel application to Render using Docker.

## Files Created

- `Dockerfile` - Multi-stage Docker build configuration
- `.dockerignore` - Files to exclude from Docker build context
- `docker/nginx.conf` - Nginx web server configuration
- `docker/supervisord.conf` - Supervisor configuration for managing services
- `docker/entrypoint.sh` - Entrypoint script for container initialization
- `render.yaml` - Render deployment configuration (optional)

## Prerequisites

1. A Render account
2. Your application code pushed to a Git repository (GitHub, GitLab, or Bitbucket)

## Deployment Steps

### Option 1: Using Render Dashboard

1. **Create a New Web Service**
   - Go to your Render dashboard
   - Click "New +" → "Web Service"
   - Connect your Git repository

2. **Configure the Service**
   - **Name**: securevault (or your preferred name)
   - **Environment**: Docker
   - **Dockerfile Path**: `./Dockerfile`
   - **Docker Context**: `.` (root directory)

3. **Set Environment Variables**
   Add the following environment variables in Render:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_KEY` - Generate using: `php artisan key:generate --show`
   - `LOG_LEVEL=error`
   - `AUTO_MIGRATE=true` (if you want automatic migrations on deploy)
   
   **Database Configuration** (if using external database):
   - `DB_CONNECTION=mysql` (or your database type)
   - `DB_HOST` - Your database host
   - `DB_PORT` - Your database port
   - `DB_DATABASE` - Your database name
   - `DB_USERNAME` - Your database username
   - `DB_PASSWORD` - Your database password

4. **Deploy**
   - Click "Create Web Service"
   - Render will build and deploy your application

### Option 2: Using render.yaml (Infrastructure as Code)

1. **Push render.yaml to your repository**
   - The `render.yaml` file is already created in the root directory

2. **Create a Blueprint**
   - In Render dashboard, go to "Blueprints"
   - Click "New Blueprint"
   - Connect your Git repository
   - Render will automatically detect and use `render.yaml`

3. **Review and Deploy**
   - Review the service configuration
   - Update environment variables as needed
   - Deploy the blueprint

## Environment Variables

### Required Variables

- `APP_KEY` - Laravel application encryption key
- `APP_ENV` - Set to `production` for production deployments

### Optional Variables

- `AUTO_MIGRATE` - Set to `true` to run migrations automatically on deploy
- `DB_*` - Database connection variables (if not using SQLite)
- `APP_URL` - Your application URL
- `SESSION_DRIVER` - Session driver (default: file)
- `CACHE_DRIVER` - Cache driver (default: file)
- `QUEUE_CONNECTION` - Queue connection (default: sync)

## Database Setup

### Using SQLite (Default)

The application is configured to use SQLite by default. The database file will be stored in `database/database.sqlite`. Make sure the storage directory has proper permissions.

### Using External Database (MySQL/PostgreSQL)

1. Create a database service in Render
2. Update environment variables with database credentials
3. Set `DB_CONNECTION` to `mysql` or `pgsql`
4. The application will automatically connect on startup

## Building Locally

To test the Docker build locally:

```bash
# Build the image
docker build -t securevault .

# Run the container
docker run -p 8080:80 \
  -e APP_KEY=base64:your-key-here \
  -e APP_ENV=production \
  -e AUTO_MIGRATE=true \
  securevault
```

Visit `http://localhost:8080` to test your application.

## Troubleshooting

### Application Key Error

If you see "No application encryption key has been specified":
- Set the `APP_KEY` environment variable in Render
- Or set `APP_KEY` to be auto-generated (entrypoint script handles this)

### Permission Errors

The Dockerfile automatically sets proper permissions for storage and cache directories. If you encounter permission issues:
- Check that the storage directory is writable
- Verify file ownership is `www-data:www-data`

### Database Connection Issues

- Verify all database environment variables are set correctly
- Check that the database service is running and accessible
- Review logs in Render dashboard for specific error messages

### Asset Build Issues

- Assets are built during the Docker build process
- If assets are missing, check the build logs in Render
- Ensure `package.json` and `vite.config.js` are correct

## Notes

- The Dockerfile uses a multi-stage build for optimization
- Assets are built during the Docker build, not at runtime
- Nginx and PHP-FPM are managed by Supervisor
- The entrypoint script handles Laravel initialization tasks
- Production optimizations (config cache, route cache, view cache) are applied automatically

## Support

For Render-specific issues, consult the [Render Documentation](https://render.com/docs).
For Laravel-specific issues, consult the [Laravel Documentation](https://laravel.com/docs).

