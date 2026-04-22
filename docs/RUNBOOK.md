# Runbook: octadecimal.cloud workspace

Operacyjny runbook dla stacku `octadecimal.cloud` (CRM + Chat + n8n + SSO).

## Architektura

```
User
 └─ CF Edge + Access (email OTP via onetimepin IdP)
     └─ CF Tunnel 01708db7-872f-4248-8b92-a824f62e6373 (PC Ubuntu)
         ├─ octadecimal.cloud         → nginx :3962 (panel prod)
         ├─ tst.octadecimal.cloud     → nginx :3963 (panel tst)
         ├─ crm.octadecimal.cloud     → nginx :3964 → php-fpm → Laravel/Filament CRM
         ├─ chat.octadecimal.cloud    → localhost:3150 → rocketchat-cloud.service
         │                              └─ MongoDB :27018 (replSet rs0-cloud)
         └─ n8n.octadecimal.cloud     → localhost:5681 → n8n-cloud.service
```

## Porty

| Port | Serwis | Notatka |
|------|--------|---------|
| 3150 | rocketchat-cloud | native Node |
| 3962 | panel prod | nginx |
| 3963 | panel tst | nginx |
| 3964 | crm.octadecimal.cloud | nginx (PRD CRM) |
| 3965 | Playwright webServer | dev only |
| 5678 | n8n.pro | docker (istniejacy) |
| 5681 | n8n-cloud | native |
| 5682 | n8n-cloud task broker | internal |
| 27017 | mongod default | DISABLED |
| 27018 | mongod-cloud | rs0-cloud PRIMARY |

## Systemd units

| Unit | Status | Lokacja |
|------|--------|---------|
| `mongod-cloud.service` | enabled | `/etc/systemd/system/` |
| `rocketchat-cloud.service` | enabled | `/etc/systemd/system/` |
| `n8n-cloud.service` | enabled | `/etc/systemd/system/` |

## Dane (osobne od .octadecimal.pro)

- MongoDB: `/var/lib/mongodb-cloud/`
- Rocket.Chat kod: `/opt/rocketchat-cloud/Rocket.Chat/`
- Rocket.Chat avatary: `/var/lib/rocketchat-cloud/avatars/`
- n8n-cloud: `/var/lib/n8n-cloud/`
- Laravel CRM: `/var/www/crm-octadecimal.cloud/` (git deploy from main)
- MySQL database: `crm_octadecimal_prd`

## Logi

```bash
# Rocket.Chat
sudo tail -f /var/log/rocketchat-cloud/rocketchat.log
sudo tail -f /var/log/rocketchat-cloud/rocketchat.err.log

# MongoDB-cloud
sudo tail -f /var/log/mongodb-cloud/mongod.log

# n8n-cloud (journald)
sudo journalctl -u n8n-cloud -f

# Laravel CRM
sudo tail -f /var/www/crm-octadecimal.cloud/storage/logs/laravel.log
```

## Sekrety (Doppler: `octadecimal-agents/prd_dev-teams`)

| Klucz | Opis |
|-------|------|
| `CLOUDFLARE_FULL_PERMMISIONS` | CF API token (tunnel + DNS + Access) |
| `TWENTY_API_KEY` | Twenty CRM REST |
| `RC_CLOUD_ADMIN_USER/PASS/EMAIL` | RC bootstrap admin |
| `RC_CLOUD_MONGO_URL` | `mongodb://localhost:27018/rocketchat?replicaSet=rs0-cloud` |
| `RC_CLOUD_MONGO_OPLOG_URL` | `mongodb://localhost:27018/local?replicaSet=rs0-cloud` |
| `RC_CLOUD_PORT` | 3150 |
| `N8N_CLOUD_ENCRYPTION_KEY` | n8n credentials encryption |
| `N8N_CLOUD_BASIC_AUTH_USER/PASS` | backup auth |
| `N8N_CLOUD_WEBHOOK_URL` | `https://n8n.octadecimal.cloud/` |
| `N8N_CLOUD_PORT` | 5681 |
| `CF_ACCESS_AUD_CHAT` | `775c5264...` |
| `CF_ACCESS_AUD_PANEL` | `98775ead...` |
| `CF_ACCESS_AUD_PANEL_TST` | `352e6b77...` |

## Cloudflare Access apps

| Aplikacja | Domena | AUD prefix | Polityka |
|-----------|--------|------------|----------|
| Octadecimal Cloud Panel | octadecimal.cloud | `98775ead` | OTP Piotr |
| Octadecimal Cloud Panel (tst) | tst.octadecimal.cloud | `352e6b77` | OTP Piotr |
| CRM Cloud (Filament Panel) | crm.octadecimal.cloud | (istniejacy) | OTP Piotr |
| Chat Cloud | chat.octadecimal.cloud | `775c5264` | OTP Piotr |
| n8n Cloud | n8n.octadecimal.cloud | `dd9c5b3f` | OTP Piotr |
| n8n Cloud Webhook Bypass | n8n.octadecimal.cloud/webhook | `1f533a39` | Service Auth (Bypass) |

IdP: `onetimepin` (id `b48c1597-3128-4573-983e-22c88b10e24a`).

## Operacje

### Restart serwisow

```bash
sudo systemctl restart mongod-cloud
sudo systemctl restart rocketchat-cloud
sudo systemctl restart n8n-cloud
```

### Status

```bash
sudo systemctl status mongod-cloud rocketchat-cloud n8n-cloud
```

### MongoDB shell

```bash
mongosh mongodb://localhost:27018/rocketchat?replicaSet=rs0-cloud
```

### Rocket.Chat API (z localhost)

```bash
# Info
curl -s http://localhost:3150/api/info | jq

# Admin login (token do /tmp/rc_token)
curl -s http://localhost:3150/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"user":"admin","password":"<from Doppler>"}'
```

### Deploy CRM (main -> PRD)

```bash
ssh piotradamczyk@192.0.2.10 \
  'cd /var/www/crm-octadecimal.cloud && \
   sudo -u www-data git pull origin main && \
   sudo -u www-data php artisan migrate --force && \
   sudo -u www-data php artisan filament:cache-components && \
   sudo -u www-data php artisan view:clear && \
   sudo -u www-data php artisan config:cache'
```

## Smoke tests

```bash
# 1. CF Access chroni wszystkie app (302 redirect)
for h in octadecimal.cloud tst.octadecimal.cloud crm.octadecimal.cloud chat.octadecimal.cloud n8n.octadecimal.cloud; do
  curl -s -o /dev/null -w "%{http_code} $h\n" "https://$h/"
done
# Oczekiwane: wszystkie 302

# 2. n8n webhook bypass dziala
curl -s -o /dev/null -w "%{http_code}" https://n8n.octadecimal.cloud/webhook/test
# Oczekiwane: 404 (z n8n, nie 302 z CF Access)

# 3. Serwisy zyja
ssh piotradamczyk@192.0.2.10 'sudo systemctl is-active mongod-cloud rocketchat-cloud n8n-cloud'
# Oczekiwane: active x3

# 4. RC API responds
ssh piotradamczyk@192.0.2.10 'curl -s http://localhost:3150/api/info | jq .version'
# Oczekiwane: "8.3"

# 5. Izolacja od .pro - oba docker RC dalej dzialaja
ssh piotradamczyk@192.0.2.10 'docker ps --format "{{.Names}}" | grep -E "rocketchat|twenty|rc-mongodb"'
# Oczekiwane: rocketchat, rocketchat-ledsee, rc-mongodb, rocketchat-ledsee-mongo
```

## Playwright e2e (z panelu CRM)

```bash
cd /home/piotradamczyk/Code/agents/dev-teams/panel/crm
npx playwright test tests/e2e/chat-page.spec.ts tests/e2e/n8n-page.spec.ts --project=chromium
# Oczekiwane: 6/6 passing
```

## Backup

```bash
# MongoDB cloud
sudo -u mongodb mongodump --uri="mongodb://localhost:27018/rocketchat?replicaSet=rs0-cloud" --out=/backup/mongo-cloud-$(date +%F)

# n8n-cloud
sudo tar czf /backup/n8n-cloud-$(date +%F).tgz /var/lib/n8n-cloud

# Laravel CRM DB
mysqldump crm_octadecimal_prd > /backup/crm-$(date +%F).sql
```

## Troubleshooting

### RC nie startuje: "replica set not found"
```bash
mongosh mongodb://localhost:27018 --eval "rs.status()"
# Jesli NOT_YET_INITIALIZED:
mongosh mongodb://localhost:27018 --eval 'rs.initiate({_id:"rs0-cloud", members:[{_id:0,host:"localhost:27018"}]})'
```

### n8n port conflict (5679 busy)
n8n task broker default port 5679 konfliktuje z .pro. Unit ma override:
`N8N_RUNNERS_BROKER_PORT=5682` + `N8N_RUNNERS_TASK_BROKER_PORT=5682`.

### Iframe pusty w panel
- Sprawdz CF Access: user musi miec cookie dla obu subdomen
- Po OTP na `crm.octadecimal.cloud` musi tez OTP na `chat.`/`n8n.` (pierwsza wizyta)
- Kolejne wizyty auto-auth przez IdP session

### MongoDB deprecation (RC 9.0 wymaga 8.0+)
Przed upgrade'em RC do 9.x -> upgrade mongod-cloud do 8.0 (apt).

## CRM tracking

- STORY: AUT-0076 (Twenty CRM `b07f185b-7bf7-40df-abe1-664af396e7b0`)
- 12 subtasks AUT-0077..0088 — status w Twenty
