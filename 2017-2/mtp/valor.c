#include "stdio.h"

int soma(int,int);
int main(){
  int x=10,y=30;


  printf (" x = %d    Y = %d   Cópia A    =  %d \n",x,y,soma(x,y));   
  return 0;
}

int soma(int a, int b){
   return (++a);
  //return a;
}
