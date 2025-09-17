#!/bin/bash

# Script de déploiement automatique pour OVH
# Configuration FTP (à personnaliser)
FTP_HOST="ftp.vialasjules.com"  # Remplacez par votre serveur FTP OVH
FTP_USER="votre_utilisateur_ftp"  # Remplacez par votre nom d'utilisateur FTP
FTP_PASS="votre_mot_de_passe"     # Remplacez par votre mot de passe FTP
REMOTE_DIR="/www"

echo "🚀 Déploiement vers OVH..."

# Créer un archive temporaire
echo "📦 Création de l'archive..."
zip -r temp_deploy.zip public/ src/ -x "*.DS_Store" "*.git*"

# Upload via FTP (nécessite lftp)
echo "⬆️ Upload vers le serveur..."
lftp -c "
set ftp:ssl-allow no
open ftp://$FTP_USER:$FTP_PASS@$FTP_HOST
cd $REMOTE_DIR
put temp_deploy.zip
quit
"

# Nettoyage
rm temp_deploy.zip

echo "✅ Déploiement terminé!"
echo "💡 N'oubliez pas de décompresser l'archive sur le serveur OVH"