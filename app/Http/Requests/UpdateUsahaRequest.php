<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsahaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_usaha' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_usahas,id',
            'kelurahan_id' => 'required|exists:kelurahans,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'foto_usaha' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'dokumen' => 'nullable|array',
            'dokumen.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'jenis_dokumen' => 'nullable|array',
            'jenis_dokumen.*' => 'in:KTP,foto_lokasi,lainnya',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_usaha.required' => 'Nama usaha wajib diisi',
            'kategori_id.required' => 'Kategori usaha wajib dipilih',
            'kategori_id.exists' => 'Kategori usaha tidak valid',
            'kelurahan_id.required' => 'Kelurahan wajib dipilih',
            'kelurahan_id.exists' => 'Kelurahan tidak valid',
            'latitude.required' => 'Lokasi belum dipilih di peta',
            'latitude.between' => 'Koordinat latitude tidak valid',
            'longitude.required' => 'Lokasi belum dipilih di peta',
            'longitude.between' => 'Koordinat longitude tidak valid',
            'foto_usaha.image' => 'File harus berupa gambar',
            'foto_usaha.max' => 'Ukuran foto maksimal 2MB',
            'dokumen.*.max' => 'Ukuran dokumen maksimal 2MB',
        ];
    }
}
