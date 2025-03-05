@echo off
title Iniciando Proyectos React

echo Iniciando React_practica en puerto 3000...
start cmd /k "cd /d %~dp0React_nuevo\app-first && set PORT=3002 && npm start"


timeout /t 3

echo Iniciando React-API en puerto 3001...
start cmd /k "cd /d %~dp0react-api && set PORT=3001 && npm start"

echo Todos los proyectos han sido iniciados.
pause
