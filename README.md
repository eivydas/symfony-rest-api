# Symfony REST Api

## Installation
1. Download files
2. Navigate to downloaded files directory
3. Run `composer install` to install required packages

## Usage
 - in `.env` change `GITHUB_USER_ORG` and `GITHUB_REPOSITORY` values to required repository
 - curl -v -H "Authorization: Bearer `[github_token]`" `[url]`

## Endpoints
### Get all issues
`/issues`  
`/issues?creator=[username]&label=[label]`

### Get my issues  
`/issues/my`  
`/issues/my?label[label]`

### Add comment to selected issue
`/issues/my/[issue_id]/comment?body=[comment]`
