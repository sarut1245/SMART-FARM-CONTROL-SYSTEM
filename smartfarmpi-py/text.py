import os
import logging
import logging.handlers

LOG_FILENAME = "logs/app.log"

if (not os.path.exists("logs")):
    os.makedirs("logs")

handler = logging.handlers.RotatingFileHandler(LOG_FILENAME, maxBytes=20*1024*1024, backupCount=5 )

logging.basicConfig(handlers=[handler], 
    level=logging.NOTSET,
    format="[%(asctime)s] %(levelname)s [%(name)s.%(funcName)s:%(lineno)d] %(message)s",
    datefmt='%Y-%m-%dT%H:%M:%S')
logger = logging

def write(t):
    logger.info(t)
    print(t, end="")

def writeln(t):
    write(t)
    print('\r\n', end="", flush=True)

def error(t):
    logger.error(t)
    writeln("Error: " + t)