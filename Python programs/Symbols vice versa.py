# програмка принимает у юзера четыре символа сразу и выдает их задом наперед

list = []

ele = input("Print any 4 symbols: ")
for x in ele: 
    list.append(x)

i = 3
while i >= 0:
    print(list[i], end="")
    i = i - 1

    
