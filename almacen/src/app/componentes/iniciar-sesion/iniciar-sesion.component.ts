import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-iniciar-sesion',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './iniciar-sesion.component.html',
  styleUrls: ['./iniciar-sesion.component.css']
})
export class IniciarSesionComponent {
  correoEmpleado: string = '';
  passwordEmpleado: string = '';

  constructor(private http: HttpClient, private router: Router) {}

  iniciarSesion() {
    const datos = {
      correoEmpleado: this.correoEmpleado,
      passwordEmpleado: this.passwordEmpleado
    };

    this.http.post<any>('http://localhost:8000/api/login', datos).subscribe(
      res => {
        if (res.success) {
          localStorage.setItem('token', res.token);
          this.router.navigate(['/miscelanea']);
        } else {
          alert('Correo o contraseña incorrectos');
        }
      },
      error => {
        console.error('Error en la solicitud:', error);
        alert('Error en el servidor');
      }
    );
  }
}
