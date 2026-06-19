<?php

namespace App\Http\Controllers;

use App\Models\GuestSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;
use App\Services\IaeService;

#[OA\Tag(
    name: "Layanan Tamu",
    description: "Guest Service API"
)]
class GuestSessionController extends Controller
{
    #[OA\Post(
        path: "/api/v1/guest-sessions",
        operationId: "createGuestSession",
        tags: ["Layanan Tamu"],
        summary: "Membuat sesi tamu baru",
        security: [["ApiKeyAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["room_number", "guest_name"],
                properties: [
                    new OA\Property(
                        property: "room_number",
                        type: "string",
                        example: "318"
                    ),
                    new OA\Property(
                        property: "guest_name",
                        type: "string",
                        example: "Ricad"
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Berhasil membuat sesi tamu"
            )
        ]
    )]
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10',
            'guest_name' => 'required|string|max:100',
        ]);

        $session = GuestSession::create([
            'room_number' => $validated['room_number'],
            'guest_name' => $validated['guest_name'],
            'session_token' => Str::random(64),
            'check_in_at' => now(),
            'status' => 'active'
        ]);

        $iaeService = new IaeService();

        $auditData = [
            'guest_session_id' => $session->id,
            'guest_name' => $session->guest_name,
            'room_number' => $session->room_number,
            'status' => $session->status,
            'check_in_at' => $session->check_in_at,
        ];

        $receiptNumber = $iaeService->auditSoap($auditData);

        $session->update([
            'receipt_number' => $receiptNumber
        ]);

        $iaeService->publishRabbitMq([
            'event' => 'guest.session.created',
            'team_id' => env('IAE_TEAM_ID'),
            'data' => [
                'guest_session_id' => $session->id,
                'guest_name' => $session->guest_name,
                'room_number' => $session->room_number,
                'status' => $session->status,
                'check_in_at' => $session->check_in_at,
            ]
        ]);

        return response()->json([
            'message' => 'Sesi tamu berhasil dibuat',
            'receipt_number' => $receiptNumber,
            'data' => $session->fresh()
        ], 201);
    }

    #[OA\Get(
        path: "/api/v1/guest-sessions",
        operationId: "getAllGuestSessions",
        tags: ["Layanan Tamu"],
        summary: "Mengambil semua sesi tamu",
        security: [["ApiKeyAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Berhasil mengambil data"
            )
        ]
    )]
    public function index()
    {
        return response()->json([
            'message' => 'Berhasil mengambil semua data sesi tamu',
            'data' => GuestSession::all()
        ]);
    }

    #[OA\Get(
        path: "/api/v1/guest-sessions/{id}",
        operationId: "getGuestSessionById",
        tags: ["Layanan Tamu"],
        summary: "Mengambil detail sesi tamu",
        security: [["ApiKeyAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Data ditemukan"
            ),
            new OA\Response(
                response: 404,
                description: "Data tidak ditemukan"
            )
        ]
    )]
    public function show($id)
    {
        $session = GuestSession::find($id);

        if (!$session) {
            return response()->json([
                'message' => 'Data sesi tamu tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Detail sesi tamu',
            'data' => $session
        ]);
    }

    #[OA\Put(
        path: "/api/v1/guest-sessions/{id}",
        operationId: "updateGuestSession",
        tags: ["Layanan Tamu"],
        summary: "Memperbarui sesi tamu",
        security: [["ApiKeyAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "room_number",
                        type: "string",
                        example: "320"
                    ),
                    new OA\Property(
                        property: "check_out_at",
                        type: "string",
                        example: "2026-06-10 12:00:00"
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Berhasil diperbarui"
            ),
            new OA\Response(
                response: 404,
                description: "Data tidak ditemukan"
            )
        ]
    )]
    public function update(Request $request, $id)
    {
        $session = GuestSession::find($id);

        if (!$session) {
            return response()->json([
                'message' => 'Data sesi tamu tidak ditemukan'
            ], 404);
        }

        $session->update([
            'room_number' => $request->room_number ?? $session->room_number,
            'check_out_at' => $request->check_out_at ?? $session->check_out_at,
        ]);

        return response()->json([
            'message' => 'Data sesi tamu berhasil diperbarui',
            'data' => $session->fresh()
        ]);
    }
}