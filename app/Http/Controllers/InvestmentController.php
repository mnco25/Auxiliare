<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Project;
use App\Models\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvestmentController extends Controller
{
    public function invest(Request $request, Project $project)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:' . $project->minimum_investment],
        ]);

        $investor = auth()->user();
        $amount = $request->amount;

        if ($investor->balance < $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient balance'
            ], 400);
        }

        DB::transaction(function () use ($project, $investor, $amount) {
            // Create investment record
            $investment = Investment::create([
                'investor_id' => $investor->id,
                'project_id' => $project->id,
                'investment_amount' => $amount,
                'investment_status' => 'Confirmed'
            ]);

            // Update investor balance
            $investor->balance -= $amount;
            $investor->save();

            // Update project funding
            $project->current_funding += $amount;
            $project->save();

            // Create transaction record
            Transaction::create([
                'investment_id' => $investment->id,
                'user_id' => $investor->id,
                'amount' => $amount,
                'transaction_type' => 'Investment',
                'transaction_status' => 'Success'
            ]);

            // Notify entrepreneur
            Notification::create([
                'user_id' => $project->user_id,
                'type' => 'investment_received',
                'title' => 'New Investment Received',
                'message' => "Your project '{$project->title}' received a new investment of ₱" . number_format($amount),
                'data' => json_encode([
                    'project_id' => $project->id,
                    'amount' => $amount
                ])
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Investment successful',
            'new_balance' => $investor->balance,
            'project_funding' => $project->current_funding
        ]);
    }
}