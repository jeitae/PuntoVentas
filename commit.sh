echo "Digite un comentario para el commit"

read comentario

git pull https://github.com/jeitae/PuntoVentas

git status

git add .

git commit -m $comentario -a

git push https://github.com/jeitae/PuntoVentas

echo "Commit realizado"
echo
