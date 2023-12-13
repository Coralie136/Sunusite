@color 2
@echo WELCOME to BACKUP TOOL restaurant_db
@echo **********************************************

mysql -h localhost -u root -p restaurant_db < backup_restaurant_db.sql

@pause