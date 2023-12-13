@echo WELCOME to DO BACKUP TOOL restorant_db
mysqldump -u root -h localhost -p restaurant_db --routines > backup_restaurant_db2.sql
@PAUSE