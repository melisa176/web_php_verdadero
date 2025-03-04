@echo off
title Iniciando Proyectos React
echo Iniciando React_practica...
start cmd /k "cd /d %~dp0React_nuevo\app-first && npm start"

timeout /t 3

echo Iniciando React-API...
start cmd /k "cd /d %~dp0react-api && npm start"

echo Todos los proyectos han sido iniciados.
pause