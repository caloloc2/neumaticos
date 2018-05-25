import time
import RPi.GPIO as GPIO

GPIO.setmode(GPIO.BCM)
GPIO.setup(18, GPIO.OUT) ## GPIO 18 como salida

while True:
	GPIO.output(18, True) ## Enciendo el 2
	time.sleep(0.5) # tiempo de espera 
	GPIO.output(18, False) ## Enciendo el 2	
	time.sleep(0.5) # tiempo de espera 