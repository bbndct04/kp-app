<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('case_number')->nullable()->after('reference_number');
            $table->string('case_level')->default('mediation')->after('case_number');
            $table->string('respondent_name')->nullable()->after('persons_involved');
            $table->string('respondent_address')->nullable()->after('respondent_name');
            $table->string('complainant_formal_name')->nullable()->after('respondent_address');
            $table->text('relief_requested')->nullable()->after('complainant_formal_name');
            $table->date('hearing_date')->nullable()->after('relief_requested');
            $table->time('hearing_time')->nullable()->after('hearing_date');
            $table->string('punong_barangay')->nullable()->after('hearing_time');
            $table->string('pangkat_chairman')->nullable()->after('punong_barangay');
            $table->text('mediation_notes')->nullable()->after('pangkat_chairman');
            $table->string('mediation_outcome')->nullable()->after('mediation_notes');
            $table->text('settlement_details')->nullable()->after('mediation_outcome');
            $table->text('escalation_reason')->nullable()->after('settlement_details');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn([
                'case_number','case_level','respondent_name','respondent_address',
                'complainant_formal_name','relief_requested','hearing_date','hearing_time',
                'punong_barangay','pangkat_chairman','mediation_notes','mediation_outcome',
                'settlement_details','escalation_reason',
            ]);
        });
    }
};