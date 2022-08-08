x = int(input("Print first number: "))
y = int(input("Print second number: "))
z = int(input("Print third number: "))

if x%2 != 0 and y%2 != 0 and z%2 != 0:
    print("Sorry, there are only odd numbers")
    

elif x%2 !=0 and y%2 !=0:
        print(z)
elif y%2 !=0 and z%2 !=0:
        print(x)
elif x%2 !=0 and z%2 !=0:
        print(y)


elif x%2 == 0 and y%2 == 0 and z%2 != 0:
    if x > y:
        print(x)
    else:
        print(y)

elif y%2 == 0 and z%2 == 0 and x%2 != 0:
    if y > z:
        print(y)
    else:
        print(z)

elif x%2 == 0 and z%2 == 0 and y%2 != 0:
    if z > x:
        print(z)
    else:
        print(x)


elif x%2 == 0 and y%2 == 0 and z%2 == 0:
    if x>y and x>z:
        print(x)
    elif y>z and y>x:
        print(y)
    elif z>x and z>y:
        print(z)



            


    



    
