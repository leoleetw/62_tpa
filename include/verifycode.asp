<?php
Option Explicit        ' ����n��

Class Com_GifCode_Class

    Public Noisy, Count, Width, Height, Angle, Offset, Border

    Private Graph(), Margin(3)

    Private Sub Class_Initialize()
        Randomize
        Noisy    = 10    ' �z�Z�I�X�{�����v
        Count    = 4    ' �r�żƶq
        Width    = 80    ' �Ϥ��e��
        Height    = 20    ' �Ϥ�����
        Angle    = 2    ' �����H���ܤƶq
        Offset    = 10    ' �����H���ܤƶq
        Border = 2    ' ��ؤj�p
    End Sub

    Public Function Create()

        Const cCharSet = "123456789"

        Dim i, x, y

        Dim vValidCode : vValidCode = ""
        Dim vIndex

        ReDim Graph(Width-1, Height-1)

        For i = 0 To Count - 1
            vIndex = Int(Rnd * Len(cCharSet))
            vValidCode = vValidCode + Mid(cCharSet, vIndex+1 , 1)
            SetDraw vIndex, i
        Next

        Create = vValidCode

    End Function

    Sub SetDot(pX, pY)
        If pX * (Width-pX-1) >= 0 And pY * (Height-pY-1) >= 0 Then
            Graph(pX, pY) = 1
        End If
    End Sub

    Public Sub SetDraw(pIndex, pNumber)

        ' �r�żƾ�
        Dim DotData(8)
        DotData(0) = Array(30, 15, 50, 1, 50, 100)
        DotData(1) = Array(1 ,34 ,30 ,1 ,71, 1, 100, 34, 1, 100, 93, 100, 100, 86)
        DotData(2) = Array(1, 1, 100, 1, 42, 42, 100, 70, 50, 100, 1, 70)
        DotData(3) = Array(100, 73, 6, 73, 75, 6, 75, 100)
        DotData(4) = Array(100, 1, 1, 1, 1, 50, 50, 35, 100, 55, 100, 80, 50, 100, 1, 95)
        DotData(5) = Array(100, 20, 70, 1, 20, 1, 1, 30, 1, 80, 30, 100, 70, 100, 100, 80, 100, 60, 70, 50, 30, 50, 1, 60)
        DotData(6) = Array(6, 26, 6, 6, 100, 6, 53, 100)
        DotData(7) = Array(100, 30, 100, 20, 70, 1, 30, 1, 1, 20, 1, 30, 100, 70, 100, 80, 70, 100, 30, 100, 1, 80, 1, 70, 100, 30)
        DotData(8) = Array(1, 80, 30, 100, 80, 100, 100, 70, 100, 20, 70, 1, 30, 1, 1, 20, 1, 40, 30, 50, 70, 50, 100, 40)

        Dim vExtent : vExtent = Width / Count
        Margin(0) = Border + vExtent * (Rnd * Offset) / 100 + Margin(1)
        Margin(1) = vExtent * (pNumber + 1) - Border - vExtent * (Rnd * Offset) / 100
        Margin(2) = Border + Height * (Rnd * Offset) / 100
        Margin(3) = Height - Border - Height * (Rnd * Offset) / 100

        Dim vStartX, vEndX, vStartY, vEndY
        Dim vWidth, vHeight, vDX, vDY, vDeltaT

        Dim vAngle, vLength

        vWidth = Int(Margin(1) - Margin(0))

        vHeight = Int(Margin(3) - Margin(2))

        ' �_�l����
        vStartX = Int((DotData(pIndex)(0)-1) * vWidth / 100)

        vStartY = Int((DotData(pIndex)(1)-1) * vHeight / 100)

        Dim i, j
        For i = 1 To UBound(DotData(pIndex), 1)/2

            If DotData(pIndex)(2*i-2) <> 0 And DotData(pIndex)(2*i) <> 0 Then

                ' ���I����
                vEndX = (DotData(pIndex)(2*i)-1) * vWidth / 100

                vEndY = (DotData(pIndex)(2*i+1)-1) * vHeight / 100

                ' ��V�t�Z
                vDX = vEndX - vStartX
                ' �a�V�t�Z
                vDY = vEndY - vStartY

                ' �ɱר���
                If vDX = 0 Then
                    vAngle = Sgn(vDY) * 3.14/2
                Else
                    vAngle = Atn(vDY / vDX)
                End If

                ' �⧤�жZ��
                If Sin(vAngle) = 0 Then
                    vLength = vDX
                Else
                    vLength = vDY / Sin(vAngle)
                End If

                ' �H����ʨ���
                vAngle = vAngle + (Rnd - 0.5) * 2 * Angle * 3.14 * 2 / 100

                vDX = Int(Cos(vAngle) * vLength)

                vDY = Int(Sin(vAngle) * vLength)

                If Abs(vDX) > Abs(vDY) Then vDeltaT = Abs(vDX) Else vDeltaT = Abs(vDY)

                For j = 1 To vDeltaT
                    SetDot Margin(0) + vStartX + j * vDX / vDeltaT, Margin(2) + vStartY + j * vDY / vDeltaT
                Next

                vStartX = vStartX + vDX

                vStartY = vStartY + vDY
            End If
        Next
    End Sub

    Public Sub Output()

        Response.Expires = -9999
        Response.AddHeader "pragma", "no-cache"
        Response.AddHeader "cache-ctrol", "no-cache"
        Response.ContentType = "image/gif"

        ' �������
        Response.BinaryWrite ChrB(Asc("G")) & ChrB(Asc("I")) & ChrB(Asc("F"))
        ' �����H��
        Response.BinaryWrite ChrB(Asc("8")) & ChrB(Asc("9")) & ChrB(Asc("a"))
        ' �޿�̹��e��
        Response.BinaryWrite ChrB(Width Mod 256) & ChrB((Width \ 256) Mod 256)
        ' �޿�̹�����
        Response.BinaryWrite ChrB(Height Mod 256) & ChrB((Height \ 256) Mod 256)

        Response.BinaryWrite ChrB(128) & ChrB(0) & ChrB(0)
        ' �����C��C��
        Response.BinaryWrite ChrB(255) & ChrB(255) & ChrB(255)

        Response.BinaryWrite ChrB(0) & ChrB(85) & ChrB(255)

        ' �Ϲ����Ѳ�
        Response.BinaryWrite ChrB(Asc(","))

        Response.BinaryWrite ChrB(0) & ChrB(0) & ChrB(0) & ChrB(0)
        ' �Ϲ��e��
        Response.BinaryWrite ChrB(Width Mod 256) & ChrB((Width \ 256) Mod 256)
        ' �Ϲ�����
        Response.BinaryWrite ChrB(Height Mod 256) & ChrB((Height \ 256) Mod 256)

        Response.BinaryWrite ChrB(0) & ChrB(7) & ChrB(255)

        Dim x, y, i : i = 0
        For y = 0 To Height - 1
            For x = 0 To Width - 1
                If Rnd < Noisy / 100 Then
                    Response.BinaryWrite ChrB(1-Graph(x, y))
                Else
                    If x * (x-Width) = 0 Or y * (y-Height) = 0 Then
                        Response.BinaryWrite ChrB(Graph(x, y))
                    Else
                        If Graph(x-1, y) = 1 Or Graph(x, y) Or Graph(x, y-1) = 1 Then
                            Response.BinaryWrite ChrB(1)
                        Else
                            Response.BinaryWrite ChrB(0)
                        End If
                    End If
                End If
                If (y * Width + x + 1) Mod 126 = 0 Then
                    Response.BinaryWrite ChrB(128)
                    i = i + 1
                End If
                If (y * Width + x + i + 1) Mod 255 = 0 Then
                    If (Width*Height - y * Width - x - 1) > 255 Then
                        Response.BinaryWrite ChrB(255)
                    Else
                        Response.BinaryWrite ChrB(Width * Height Mod 255)
                    End If
                End If
            Next
        Next
        Response.BinaryWrite ChrB(128) & ChrB(0) & ChrB(129) & ChrB(0) & ChrB(59)
    End Sub
End Class

Dim mCode
Set mCode = New Com_GifCode_Class
Session("VerifyCode") = mCode.Create()
mCode.Output()
Set mCode = Nothing
?>